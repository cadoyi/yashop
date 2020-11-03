<?php

namespace common\assets;

use Yii;

/**
 * 前后台通用的 asset, 统一前后台样式. 基于 Bootstrap4 框架
 * 
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CommonAsset extends AssetBundle
{

    public $asset = 'common';

    public $css = [
        'css/common.css',
    ];


    public $js = [
        'js/common.js',
    ];

}