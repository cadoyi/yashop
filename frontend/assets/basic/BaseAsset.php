<?php

namespace frontend\assets\basic;

use Yii;


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
        CommonAsset::class,
    ];



}