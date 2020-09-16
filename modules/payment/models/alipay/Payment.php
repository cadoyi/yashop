<?php

namespace payment\models\alipay;

use Yii;
use yii\base\Component;
use Alipay\EasySDK\Kernel\Factory;
use Alipay\EasySDK\Kernel\Util\ResponseChecker;
use Alipay\EasySDK\Kernel\Config;
use Alipay\EasySDK\Kernel\Util\Signer;

/**
 * 支付宝支付通用逻辑.
 * 需要安装: alipaysdk/easysdk:^2.0
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
abstract class Payment extends Component
{

    /**
     * @var boolean 标记 Factory 是否已经设置了选项. 全局只需要设置一次.
     */
    protected static $_optionInited = false;


    /**
     * 初始化配置.
     */
    public function getOptions()
    {
        return [
            // 协议 - 这是请求 gatewayHost 使用的协议.
            'protocol'           => 'https',

            // 支付网关主机名称, url 路径固定为 '/gateway.do'
            'gatewayHost'        => 'openapi.alipay.com',

            // APP ID, 不能为空.
            'appId'              => null,

            // 加密类型, 
            'signType'           => 'RSA2',

            // 如果采用非证书模式, 这个参数需要提供支付宝公钥
            'alipayPublicKey'    => null,

            // 支付宝公钥证书文件路径.
            'alipayCertPath'     => null,

            // 支付宝公钥证书签名
            'alipayCertSN'       => null,

            // 支付宝根证书文件路径.
            'alipayRootCertPath' => null,

            // 支付宝根证书签名
            'alipayRootCertSN'   => null,

            // 应用私钥串
            'merchantPrivateKey' => null,

            // 应用公钥证书文件路径
            'merchantCertPath'   => null,

            // 应用公钥证书签名
            'merchantCertSN'     => null,

            // 可选 - 异步通知的 URL
            'notifyUrl'          => null,

            // 可选 - AES 秘钥, 调用 AES 加密相关接口的时候需要
            'encryptKey'         => null,
        ];
    }


    /**
     * 初始化 factory
     */
    protected function initPayment()
    {
        if(!static::$_optionInited) {
            $config = new Config();
            $options = $this->getOptions();
            Yii::configure($config, $options);
            Factory::setOptions($config);
            static::$_optionInited = true;
        }
    }


    /**
     * 调用 Factory::payment() 方法.
     * 
     * @return Payment
     */
    public function payment()
    {
        $this->initPayment();
        return Factory::payment();
    }



    /**
     * 获取支付宝的公钥字符串
     * 
     * @return string
     */
    public function getPublicKey()
    {
        $options = $this->getOptions();
        $publicKey = $options['alipayPublicKey'];
        if(is_string($publicKey)) {
            return $publicKey;
        }
        $publicKey = file_get_contents($options['alipayCertPath']);
        
        // 转换为 openssl 格式的证书.
        return openssl_get_publickey($publicKey);
    }

     
    /**
     * 验证 response 签名.
     *    response 签名会取出 sign 和 sign_type 参数
     * 
     * @param  array $params 请求参数
     * @return boolean
     */
    public function verifyResponse( $params )
    {
        $model = new Signer();
        return $model->verifyParams($params, $this->getPublicKey());
    }



}