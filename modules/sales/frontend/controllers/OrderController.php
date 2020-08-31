<?php

namespace sales\frontend\controllers;

use Yii;
use yii\base\UserException;
use frontend\controllers\Controller;
use checkout\models\Quote;
use customer\models\Customer;
use customer\models\CustomerAddress;
use catalog\helpers\Stock;
use sales\models\order\Onepage;

/**
 * order 控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderController extends Controller
{


    /**
     * 提交订单
     * 
     * @return array
     */
    public function actionSubmit()
    {
        $quote_id = $this->request->post('quote_id');
        $address_id = $this->request->post('address_id');
        $paymethod = $this->request->post('payment_method');
        try {
            if(!$quote_id || !$address_id || !$paymethod) {
                throw new UserException('Invalid request');
            }
            $quote = $this->findModel($quote_id, Quote::class, true, '_id');
            $address = $this->findModel($address_id, CustomerAddress::class, true);
            $onepage = new Onepage(['quote' => $quote, 'address' => $address]);
            $order = $onepage->saveOrder();
            $this->_success('购买成功');
            return $this->goHome();
        } catch(UserException $e) {
            $this->_error($e->getMessage());
            return $this->goBack();
        }

    }

}