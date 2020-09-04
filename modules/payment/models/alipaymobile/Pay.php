<?php

namespace payment\models\alipaymobile;

use Yii;
use yii\helpers\Json;

/**
 * 处理跳转逻辑,跳转到支付宝手机网页支付
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Pay extends Payment
{

    /**
     * @var Order 订单实例
     */
    public $order;

    
    /**
     * @var return_url 同步返回 URL.
     */
    public $returnUrl;


    /**
     * @var notify_url 异步通知 URL.
     */
    public $notifyUrl;


    /**
     * @var array 附加的请求参数.
     *    参数的 key: 方法名
     *    参数的 value: 方法参数, 以数组的方式表示.
     */
    public $requestParams = [];


    /**
     * 获取 request 对象.
     * 
     * @return AlipayTradeWapPayRequest
     */
    public function getRequest()
    {
         $request = new AlipayTradeWapPayRequest();
         $request->setReturnUrl($this->returnUrl);
         $request->setNotifyUrl($this->notifyUrl);
         foreach($this->requestParams as $method => $value) {
              call_user_func_array([$request, $method], $value);
         }
         $bizData = $this->getBizData();
         $content = Json::encode($bizData);
         $request->setBizContent($content);
         return $request;
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
           'product_code' => 'QUICK_WAP_WAY',
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
        $client = $this->getClient();
        $request = $this->getRequest();
        return $client->pageExecute($request);
    }

}