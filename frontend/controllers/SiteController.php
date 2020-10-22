<?php
namespace frontend\controllers;

use Yii;


/**
 * Site controller
 */
class SiteController extends Controller
{


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }




    /**
     * 显示主页
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }



 

}
