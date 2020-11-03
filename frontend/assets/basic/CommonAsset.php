<?php

namespace frontend\assets\basic;

use Yii;
use yii\web\YiiAsset;
use yii\web\JqueryAsset;
use yii\widgets\PjaxAsset;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use frontend\assets\AssetBundle;
use frontend\assets\lib\FontAwesomeAsset;
use frontend\assets\lib\SweetalertAsset;


/**
 * 前后台通用
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CommonAsset extends \common\assets\CommonAsset
{



    public $depends = [
        SweetalertAsset::class,
        FontAwesomeAsset::class,
        JqueryAsset::class,
        PjaxAsset::class,
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];
}