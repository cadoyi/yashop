<?php

namespace backend\assets\bs4\admin;

use Yii;
use backend\assets\bs4\AssetBundle;
use backend\assets\bs4\LoginAsset as LayoutAsset;

/**
 * login asset
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LoginAsset extends AssetBundle
{

    public $js = [];

    public $css = [
        'css/admin/login.css',
    ];

    public $depends = [
        LayoutAsset::class,
    ];

}