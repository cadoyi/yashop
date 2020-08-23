<?php

namespace frontend\assets\basic\checkout;

use Yii;
use frontend\assets\basic\AssetBundle;

/**
 * 购物车页面的逻辑
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CartAsset extends AssetBundle
{

    public $js = [
        'js/checkout/cart.js',
    ];

    public $css = [
        'css/checkout/cart.css',
    ];
}