<?php

namespace customer\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use customer\frontend\models\account\LoginForm;
use customer\frontend\models\account\RegisterForm;
use customer\frontend\models\account\SendRegisterCodeForm;
use customer\frontend\models\account\ForgotPasswordForm;
use customer\frontend\models\account\PasswordForm;
use customer\models\Customer;

/**
 * 账户控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AccountController extends Controller
{


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4,
                'width' => 120,
                'height' => 36,
            ],
        ];
    }



    /**
     * 登录
     */
    public function actionLogin()
    {
        if(!$this->user->isGuest) {
            return $this->goBack();
        }
        $this->layout = 'login';
        $model = new LoginForm();

        if($model->load($this->request->post()) && $model->login()) {
            $this->_success('Login successful');
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }



    /**
     * 登出
     */
    public function actionLogout()
    {
        if($this->user->isGuest) {
            return $this->goBack();
        }
        $this->_success('Customer logged out');
        $this->user->logout();
        return $this->goHome();
    }



    /**
     * 注册用户
     *
     * @param  string $type 注册类型
     *    email
     *    phone
     */
    public function actionRegister()
    {
        $this->layout = 'login';
        $form = new RegisterForm();
 
        if($form->load($this->request->post()) && $form->register()) {
            $customer = $form->getCustomer();
            $this->user->login($customer);
            $this->_success('Customer registered');
            return $this->goHome();
        }
        return $this->render('register', [
            'model' => $form,
        ]);
    }




    /**
     * 发送注册码
     * 
     * @param  string $username 用户名
     */
    public function actionSendRegisterCode( $username )
    {
        $form = new SendRegisterCodeForm(['username' => $username]);
        if(!$form->validate()) {
            $error = $form->getErrorMessage();
            return $this->asJson([
                'success' => false,
                'message' => $error,
            ]);
        }
        try {
            $code = $form->send();
            Yii::$app->session->set('register_code', [
                'code' => $code,
                'time' => time(),
                'username' => $username,
            ]);
            $data = [
                'success' => true,
                'username' => $username,
            ];
        } catch(\Exception $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        } catch(\Throwable $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }
        return $this->asJson($data);
    }



    /**
     * 发送忘记密码的验证码
     * 
     * @return string
     */
    public function actionSendForgotPasswordCode()
    {
        $form = new ForgotPasswordForm();
        $form->load($this->request->post(), '');
        if(!$form->validate()) {
           $data = ['success' => false, 'message' => $form->getErrorMessage()];
           return $this->asJson($data);
        }
        if(!$form->isUsernameExist()) {
            $data['success'] = true;
            return $this->asJson($data);
        }
        try {
            $code = $form->send();
            Yii::$app->session->set('customer_forgot_code', [
                'code' => $code,
                'time' => time(),
                'username' => $form->username,
            ]);
            $data = [
                'success' => true,
                'username' => $form->username,
            ];
            return $this->asJson($data);
        } catch(\Exception $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        } catch(\Throwable $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }
        return $this->asJson($data);
    }




    /**
     * 忘记密码
     * 
     * @return string
     */
    public function actionForgotPassword()
    {
        $form = new ForgotPasswordForm();
        $form->scenario = ForgotPasswordForm::SCENARIO_ACCOUNT_CODE;
        if($form->load($this->request->post()) && $form->validate()) {
            $this->session->set('forgoted_id', $form->getCustomer()->id);
            return $this->redirect(['reset-password']);
        }
        return $this->render('forgot-password', [
            'model' => $form,
        ]);
    }



    /**
     * 重置密码
     * 
     * @return string
     */
    public function actionResetPassword()
    {
        $customer_id = $this->session->get('forgoted_id');
        if(!$customer_id) {
            return $this->redirect(['forgot-password']);
        }
        $customer = $this->findModel($customer_id, Customer::class, false);
        if(!$customer) {
            $this->session->remove('forgoted_id');
            return $this->redirect(['forgot-password']);
        }
        $model = new PasswordForm(['customer' => $customer]);
        if($model->load($this->request->post()) && $model->changePassword()) {
            $this->_success('Password changed');
            $this->session->remove('forgoted_id');
            return $this->redirect(['/customer/account/login']);
        }
        return $this->render('reset-password', [
            'model' => $model,
        ]);

    }

}