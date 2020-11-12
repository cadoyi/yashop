<?php

namespace shop\assets\basic;

use Yii;

/**
 * 布局 asset
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