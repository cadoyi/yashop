<?php

namespace payment\models\alipaymobile;

use Yii;
use yii\base\Conponent;

/**
 * 支付宝手机网页支付处理通用逻辑.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
abstract class Payment extends Conponent
{

    protected $_client;


    /**
     * 获取 aopClient 实例
     * 
     * @return aopClient
     */
    public function getClient()
    {
        if(is_null($this->_client)) {
            $client = new AopClient();
            $this->initClient($client);
            $this->_client = $client;
        }
        return $this->_client;
    }



    /**
     * 获取 AopRequest 对象.
     * 
     * @return $aopRequest
     */
    abstract public function getRequest();



    /**
     * 初始化 client 请求. 设置通用参数.
     * 
     * @param  AopClient $client 
     */
    protected function initClient(AopClient $client)
    {
        /**
         * $client->appId              = 'app id';
         * $client->rsaPrivateKey      = 'private key';
         ^ $client->alipayrsaPublicKey =  'public key';
         * $client->signType = 'RSA2';
         * $client->apiVersion = '1.0';       //默认参数
         * $client->format = 'json';           //默认参数
         * $client->postCharset = 'UTF-8';     //默认参数
         * $client->gatewayUrl = 'https://openapi.alipay.com/gateway.do';  //默认参数
         */
    }



}