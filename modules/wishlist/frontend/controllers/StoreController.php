<?php

namespace wishlist\frontend\controllers;

use Yii;
use frontend\controllers\Controller;

/**
 * 收藏的店铺控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class StoreController extends Controller
{

    public $layout = 'customer';


    public function actionIndex()
    {
        return $this->render('index');
    }

}