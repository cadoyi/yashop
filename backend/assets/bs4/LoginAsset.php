<?php

namespace backend\assets\bs4;

use Yii;

/**
 * login asset
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LoginAsset extends AssetBundle
{

    public $js = [
        'js/login.js',
    ];
    
    public $css = [
        'css/login.css',
    ];

    public $depends = [
        BaseAsset::class,
    ];

}