<?php

namespace checkout\helpers;

use Yii;
use checkout\models\Quote;

/**
 * quote helper
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class QuoteHelper
{



    /**
     * 新建 quote
     * 
     * @return Quote
     */
    public static function createQuote($customer)
    {
        $quote = new Quote(['customer' => $customer]);
        if(Yii::$app instanceof \yii\web\Application) {
            $quote->remote_ip = Yii::$app->request->getUserIP();
        }
        $quote->save();
        return $quote;
    }


}