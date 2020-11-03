<?php

namespace backend\assets\bs4;

use Yii;


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
        CommonAsset::class,
    ];

}