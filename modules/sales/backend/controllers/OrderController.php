<?php

namespace sales\backend\controllers;

use Yii;
use backend\controllers\Controller;
use sales\models\filters\OrderFilter;
use sales\models\Order;

/**
 * 订单控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderController extends Controller
{


    /**
     * 列出订单.
     * 
     * @return array
     */
    public function actionIndex()
    {
        $filterModel = new OrderFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 查看订单
     */
    public function actionView($id)
    {
        $order = $this->findModel($id, Order::class);

        return $this->render('view', [
            'order' => $order,
        ]);
    }

}