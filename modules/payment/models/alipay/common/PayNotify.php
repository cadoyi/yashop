<?php

namespace payment\models\alipay\common;

use Yii;
use payment\models\alipay\Payment;
use sales\models\OrderPaid as Order;
use sales\helpers\OrderHelper;


/**
 * pay notify
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class PayNotify extends Payment
{

   /**
     * @var OrderPaid 订单实例.
     */
    public $order;

    /**
     * @var array 请求参数
     */
    public $params;


    /**
     * 验证响应参数.
     * 
     * @param  array $params 
     * @return boolean
     */
    public function verifyResponseParams( $params )
    {
        $options = $this->getOptions();
        $app_id = $options['appId'];

        // 验证 APP ID
        if(!isset($params['app_id']) || $params['app_id'] !== $app_id) {
            return false;
        }

        // 验证必要参数
        if(!isset($params['out_trade_no']) || !isset($params['total_amount']) || !isset($params['trade_status'])) {
            return false;
        }

        // 验证订单
        $incrementId = $params['out_trade_no'];
        $order = Order::findOne(['increment_id' => $incrementId]);
        if(!$order) {
            return false;
        }

        // 验证订单金额
        $amount = sprintf('%.2f', $params['total_amount']);
        $total = sprintf('%.2f', $order->grand_total);
        if($amount !== $total) {
            return false;
        }
        $this->order = $order;
        $this->params = $params;
    }



    /**
     * 验证请求
     * 
     * @param  array $params 请求参数
     */
    public function verifyResponse($params)
    {
        if(!parent::verifyResponse($params)) {
            return $this->error();
        }
        if(!$this->verifyResponseParams($params)) {
            return $this->error();
        }
    }



    /**
     * 保存订单.如果保存失败,请抛出异常.
     * 
     * @return boolean
     */
    public function saveOrder()
    {
        // 标记为已经付款
        $status = $this->params['trade_status'];
        switch($status) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                $this->order->process();
                break;
            case 'TRADE_CLOSED':
                $this->order->close();
                break;
            default:
                break;
        }
    }




    /**
     * 成功消息
     * 
     * @return string
     */
    public function success()
    {
        die('success');
    }



    
    /**
     * 失败消息
     * 
     * @return string
     */
    public function error()
    {
        die('error');
    }



}