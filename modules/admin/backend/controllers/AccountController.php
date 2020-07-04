<?php

namespace modules\admin\backend\controllers;

use Yii;
use yii\captcha\CaptchaAction;
use backend\controllers\Controller;
use modules\admin\models\User;
use modules\admin\backend\models\LoginForm;
use modules\admin\backend\vms\LoginView;

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
                'class'     => CaptchaAction::class,
                'maxLength' => 4,
                'minLength' => 4,
                'width'     => 92,
                'height'    => 36,
            ],
        ];
    }




    /**
     * @inheritdoc
     */
    public function access()
    {
        return [];
    }




    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
           'logout' => ['post'],
        ];
    }

    
    /**
     * 视图模型
     * 
     * @return array
     */
    public function viewModels()
    {
        return [
            'login' => LoginView::class,
        ];
    }



    /**
     * 登录
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        
        if(!Yii::$app->user->isGuest) {
            return $this->goBack();
        }
        $model = new LoginForm();
        if($model->load($this->request->post()) && $model->login()) {
            $this->session->addFlash('success', 'Login successful');
            return $this->goBack();
        }
        return $this->render('login', ['model' => $model]);

    }




    /**
     * 登出
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }





    

}