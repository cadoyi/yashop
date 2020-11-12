<?php

namespace shop\assets\basic;

use Yii;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;
use yii\widgets\PjaxAsset;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use shop\assets\lib\SweetalertAsset;
use shop\assets\lib\FontAwesomeAsset;
use common\assets\CommonAsset;

/**
 * base asset
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class BaseAsset extends AssetBundle
{

    public $css = [
        'css/base.css',
        'css/styles.css',
    ];

    public $js = [
        'js/base.js',
        'js/scripts.js',
    ];

    public $depends = [
        SweetalertAsset::class,
        FontAwesomeAsset::class,
        JqueryAsset::class,
        PjaxAsset::class,        
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        CommonAsset::class,
    ];
}