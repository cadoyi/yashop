<?php

namespace frontend\assets\basic;

use Yii;
use yii\web\YiiAsset;
use yii\web\JqueryAsset;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use common\assets\FontAwesomeAsset;



/**
 * 应用 asset
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AppAsset extends AssetBundle
{

    public $js = [
       'js/app.js',
    ];

    public $css = [
       'css/app.css',
    ];


    public $depends = [
        YiiAsset::class,
        JqueryAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        FontAwesomeAsset::class,
    ];

}