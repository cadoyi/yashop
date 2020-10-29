<?php

namespace backend\assets\bs4;

use Yii;

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