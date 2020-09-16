<?php

namespace payment\models\alipay\pc;

use Yii;
use payment\models\alipay\common\Pay as BasePay;


/**
 * PC 网站当面付支付接口
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Pay extends BasePay
{


    /**
     * 获取 page 支付场景
     * 
     * @return wap
     */
    public function scene()
    {
        return $this->payment()->page();
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
            $this->returnUrl
        );     
    }

}