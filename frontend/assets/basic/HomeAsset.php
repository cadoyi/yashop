<?php

namespace frontend\assets\basic;

use Yii;
use frontend\assets\lib\SwiperAsset;

/**
 * 主页
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class HomeAsset extends AssetBundle
{
    public $css = [
       'css/home.css',
    ];


    public $js = [
        'js/home.js',
    ];

    public $depends = [
        AssetBundle::class,
        SwiperAsset::class,
    ];

}