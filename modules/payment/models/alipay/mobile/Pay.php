<?php

namespace payment\models\alipay\mobile;

use Yii;
use payment\models\alipay\common\Pay as BasePay;

/**
 * 处理跳转逻辑,跳转到支付宝手机网页支付
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Pay extends BasePay
{


    /**
     * 获取 wap 支付场景
     * 
     * @return wap
     */
    public function scene()
    {
        return $this->payment()->wap();
    }



    /**
     * @inheritdoc
     */
    protected function _pay(array $bizData)
    {
        return $this->scene()->pay(
            $bizData['subject'],
            $bizData['out_trade_no'],
            $bizData['total_amount'],
            $this->quitUrl,
            $this->returnUrl
        );        
    }

}