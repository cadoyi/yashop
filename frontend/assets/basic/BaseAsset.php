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
    ];


}