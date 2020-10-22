<?php

namespace frontend\assets\basic;

use Yii;
use frontend\assets\AssetBundle;

/**
 * layout asset
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LayoutAsset extends AssetBundle
{

    public $css = [
        'css/layout.css',
    ];


    public $js = [
        'js/layout.js',
    ];


    public $depends = [
        BaseAsset::class,
    ];

}