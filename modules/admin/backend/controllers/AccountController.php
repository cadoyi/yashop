<?php

namespace admin\backend\controllers;

use Yii;
use yii\captcha\CaptchaAction;
use backend\controllers\Controller;
use admin\models\User;
use admin\backend\models\account\LoginForm;
use admin\backend\vms\account\LoginView;

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
        
        if(!$this->user->isGuest) {
            return $this->goBack();
        }
        $model = new LoginForm();
        if($model->load($this->request->post()) && $model->login()) {
            $this->_success('Login successful');
            $this->log('User login: {nickname}', [
                'nickname' => $this->identity->nickname,
            ]);
            return $this->goBack();
        }
        return $this->render('login', ['model' => $model]);

    }




    /**
     * 登出
     */
    public function actionLogout()
    {
        if($this->user->isGuest) {
            return $this->goHome();
        }
        $this->log('User logout: {nickname}', [
            'nickname' => $this->identity->nickname,
        ]);  
        Yii::$app->user->logout();
        $this->_success('User logouted');
        return $this->goHome();
    }





    

}