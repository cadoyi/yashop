<?php

namespace payment\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use sales\models\OrderPaid;


class TestController extends Controller
{


    public function actionPay()
    {
        $increment_id = $this->session->get('last_order_increment_id');
        $order = OrderPaid::findOne(['increment_id' => $increment_id]);
        $order->process();
        $this->session->set('last_paid_increment_id', $order->increment_id);
        $this->session->remove('last_order_increment_id');
        $this->_success('支付成功!');
        return $this->redirect(['/sales/order/success']);
    }
}