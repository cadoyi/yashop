<?php

namespace backend\assets\bs4;

use Yii;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;
use yii\widgets\PjaxAsset;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use backend\assets\lib\FontAwesomeAsset;
use backend\assets\lib\SweetalertAsset;

/**
 * 基本的 assets
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class BaseAsset extends AssetBundle
{

    public $js = [
        'js/base.js',
        'js/scripts.js',
    ];

    public $css = [
        'css/base.css',
        'css/styles.css',
    ];


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