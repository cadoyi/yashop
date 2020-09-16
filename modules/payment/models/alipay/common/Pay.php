<?php

namespace payment\models\alipay\common;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use payment\models\alipay\Payment;

/**
 * pc 和 mobile 统一逻辑.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
abstract class Pay extends Payment
{


    /**
     * @var Order 订单实例
     */
    public $order;

    
    /**
     * @var string return_url 同步返回 URL.
     */
    public $returnUrl;


    /**
     * @var string notify_url 异步通知 URL.
     */
    public $notifyUrl;


    /**
     * @var string quit_url 支付中途退出,返回商户的 URL,理论上应该返回未支付订单页面
     */
    public $quitUrl;



    /**
     * @inheritdoc
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), [
            'notifyUrl' => $this->notifyUrl,
        ]);
    }



    /**
     * 支付场景
     * 
     * @return 
     */
    abstract public function scene();


    /**
     * 获取具体的 pay form
     * 
     * @param  array  $bizData 
     * @return Model
     */
    abstract protected function _pay(array $bizData);
    



    /**
     * 进行支付
     * 
     * @return Response
     */
    public function pay()
    {
        $bizData = $this->getBizData();

        // 先注入可选的 BizContent 参数.
        $except = ['subject', 'out_trade_no', 'total_amount'];
        foreach($bizData as $name => $value) {
            if(!in_array($name, $except, true)) {
                $this->scene()->optional($name, $value);
            }
        }

        $response = $this->_pay($bizData);

        return $response->body;
    }


    /**
     * 获取业务请求参数.
     * 
     * @return array
     */
    protected function getBizData()
    {
        $order = $this->order;
        return [
           'out_trade_no' => $order->increment_id,
           'total_amount' => sprintf('%.2f', $order->grand_total),
           'subject'      => "Order No: #{$order->increment_id}",
           'body'         => "Order No: #{$order->increment_id}",
        ];
    }



    /**
     * 获取 form 表单
     * 
     * @return  string
     */
    public function toHtml()
    {
        return $this->pay();
    }


}