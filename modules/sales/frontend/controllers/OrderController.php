<?php

namespace sales\frontend\controllers;

use Yii;
use yii\base\UserException;
use frontend\controllers\Controller;
use sales\models\order\Submitter;
use sales\models\OrderPaid;
use payment\helpers\MethodHelper;


/**
 * order 控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderController extends Controller
{


    public function access()
    {
        return [
            'rules' => [
                 [
                     'allow' => false,
                     'roles' => ['?'],
                 ],
                 [
                      'allow' => true,
                 ],
            ],
        ];
    }


    /**
     * 提交订单
     * 
     * @return array
     */
    public function actionSubmit()
    {
        $customer   = $this->identity;
        $submitter = new Submitter([
            'customer' => $customer,
        ]);

        $submitter->load($this->request->post(), '');

        try {
            if(!$submitter->validate()) {
                 throw new UserException('Invalid request');
            }
            $order = $submitter->saveOrder();
            $this->session->set('last_order_increment_id', $order->increment_id);
            $payMethod = $order->method;
            $url = MethodHelper::getPayUrl($payMethod);
            return $this->redirect($url);
        } catch(UserException $e) {
            throw $e;
            $this->_error($e->getMessage());
            return $this->goBack();
        }

    }



    /**
     * 支付成功页面.
     * 
     * @return string
     */
    public function actionSuccess()
    {
        $increment_id = $this->session->get('last_paid_increment_id', false);
        if(!$increment_id) {
            return $this->notFound();
        }
        $this->session->remove('last_paid_increment_id');
        $orderPaid = OrderPaid::findOne(['increment_id' => $increment_id]);
        if($orderPaid->customer_id != $this->user->id) {
            return $this->notFound();
        }
        return $this->render('success', ['orderPaid' => $orderPaid]);
    }





}