<?php

namespace payment\helpers;

use Yii;
use yii\helpers\Url;

/**
 * 方法 helper
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class MethodHelper
{



    /**
     * 获取允许的支付方法
     * 
     * @return array
     */
    public static function getPaymentMethods()
    {
        return [
            'alipaymobile' => Url::to(['/payment/alipaymobile/pay'], true),
            'alipaypc'     => Url::to(['/payment/alipaypc/pay'], true),
            'alipay'       => Url::to(['/payment/test/pay'], true),
            'wxpay'        => Url::to(['/payment/test/pay'], true),
        ];
    }



    /**
     * 是否有对应的方法.
     * 
     * @param  string  $method 方法名
     * @return boolean
     */
    public static function hasPaymentMethod($method)
    {
        $methods = static::getPaymentMethods();
        return isset($methods[$method]);
    }


     
    /**
     * 获取支付 URL
     * 
     * @param  string $method  
     * @return string
     */
    public static function getPayUrl( $method )
    {
        $methods = static::getPaymentMethods();
        return $methods[$method];
    }


}