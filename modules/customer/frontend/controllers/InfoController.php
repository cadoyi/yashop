<?php

namespace customer\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use customer\models\Customer;

/**
 * 客户信息管理
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class InfoController extends Controller
{

    public $layout = 'customer-account';


    /**
     * 个人信息
     */
    public function actionIndex()
    {
        $model = $this->identity;
        if($model->load($this->request->post()) && $model->save()) {
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $this->identity,
        ]);
    }



    /**
     * 帐号安全
     */
    public function actionSecurity()
    {
        $model = $this->identity;
        return $this->render('security', [
            'model' => $model,
        ]);
    }

}