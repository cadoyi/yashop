<?php

namespace checkout\frontend\controllers;

use Yii;
use frontend\controllers\Controller;


/**
 * 一个步骤完成付款
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OnepageController extends Controller
{


    /**
     * 付款确定页面
     * 
     * @return string
     */
    public function actionIndex()
    {
        
        return $this->render('index');
    }

}