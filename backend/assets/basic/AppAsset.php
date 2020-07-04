<?php

namespace backend\assets\basic;

use Yii;
use common\assets\FontAwesomeAsset;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
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
        FontAwesomeAsset::class,
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];
}
