<?php

namespace front\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use front\frontend\models\Address;

/**
 * index controller
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class IndexController extends Controller
{


    public function actionIndex()
    {

         $address = Address::findByCustomer(39)->all();
             //->createCommand()
             //->rawSql;
        //var_dump($address);

    }

}