<?php

namespace frontend\assets\basic\customer;

use Yii;
use frontend\assets\basic\CustomerAsset;

/**
 * customer layout assets
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \frontend\assets\basic\AssetBundle
{


    public $depends = [
        CustomerAsset::class,
    ];
}