<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{


    /**
     * @inheritdoc
     */
    public function access()
    {
        return [
            'rules' => [
                [
                    'actions' => ['error'],
                    'allow' => true,
                ],
                [
                    'allow' => false,
                    'roles' => ['?'],
                ],
            ],
        ];
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }




    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    
}
