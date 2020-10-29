<?php

namespace customer\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use customer\frontend\models\account\LoginForm;
use customer\frontend\models\account\LoginCodeForm;

use customer\frontend\models\account\RegisterForm;
use customer\frontend\models\account\RegisterCodeForm;
use customer\frontend\models\account\RegisterPasswordForm;
use customer\frontend\models\account\RegisterDoneForm;
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
     * 密码登录
     */
    public function actionLogin()
    {
        if(!$this->user->isGuest) {
            return $this->goBack();
        }
        $this->layout = 'account';
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
     * 验证码登录
     */
    public function actionLoginCode()
    {
        if(!$this->user->isGuest) {
            return $this->goBack();
        }
        $this->layout = 'account';
        $model = new LoginCodeForm([
            'scenario' => LoginCodeForm::SCENARIO_CODE,
        ]);
        if($model->load($this->request->post()) && $model->login()) {
            $this->_success('Login successful');
            return $this->goHome();
        }
        return $this->render('login-code', [
            'model' => $model,
        ]);
    }



    /**
     * 发送登录验证码。
     */
    public function actionSendLoginCode()
    {
        if(!$this->user->isGuest) {
            return $this->error('页面已经过期！请刷新本页面！');
        }
        $model = new LoginCodeForm([
            'username' => $this->request->post('username'),
        ]);
        if(!$model->validate()) {
            return $this->error($model);
        }
        try {
            $model->sendCode();
        } catch(\Exception | \Throwable $e) {
            return $this->error($e);
        }
        return $this->success();
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
     * 注册用户 [填写帐号]
     *
     * @param  string $type 注册类型
     *    email
     *    phone
     */
    public function actionRegister()
    {
        $this->layout = 'account';
        $form = new RegisterForm();
 
        if($form->load($this->request->post()) && $form->validate()) {
            $form->saveUsername();
            return $this->redirect(['register-code']);
        }
        return $this->render('register', [
            'model' => $form,
        ]);
    }




    /**
     * 注册用户 [验证帐号]
     */
    public function actionRegisterCode()
    {
        $this->layout = 'account';
        $form = new RegisterCodeForm();
        if(!$form->username) {
            return $this->redirect(['register']);
        }
        if($form->load($this->request->post()) && $form->validate()) {
            $form->setIsValidated();
            return $this->redirect(['register-password']);
        }

        return $this->render('register-code', [
            'model' => $form,
        ]);
    }




    /**
     * 注册用户 ajax 发送验证码.
     */
    public function actionSendRegisterCode()
    {
        if(!$this->user->isGuest) {
            return $this->error('页面已经过期！请刷新本页面！');
        }
        $model = new SendRegisterCodeForm([
            'username' => $this->request->post('username'),
        ]);
        if(!$model->validate()) {
            return $this->error($model);
        }
        try {
            $model->sendCode();
        } catch(\Exception | \Throwable $e) {
            return $this->error($e);
        }
        return $this->success();
    }



    /**
     * 注册用户 [填写密码]
     */
    public function actionRegisterPassword()
    {
        $this->layout = 'account';
        $form = new RegisterPasswordForm();
        if(!$form->username) {
            return $this->redirect(['register']);
        }
        if(!$form->isValidated()) {
            return $this->redirect(['register-code']);
        }

        if($form->load($this->request->post()) && $form->register()) {
            return $this->redirect(['register-done']);
        }

        return $this->render('register-password', [
            'model' => $form,
        ]);
    }


    
    /**
     * 注册用户 [注册成功]
     */
    public function actionRegisterDone()
    {
        $this->layout = 'account';
        $form = new RegisterDoneForm();
        if(!$form->isRegistered()) {
            return $this->redirect(['register']);
        }
        $form->clear();
        return $this->render('register-done', [
            'model' => $form,
        ]);
    }









    /**
     * 忘记密码
     * 
     * @return string
     */
    public function actionForgotPassword()
    {
        if(!$this->user->isGuest) {
            return $this->notFound();
        }

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