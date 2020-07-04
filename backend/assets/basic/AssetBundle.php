<?php

namespace backend\assets\basic;

use Yii;

/**
 * assets bundle 基类
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \backend\assets\AssetBundle
{

    public $basePath = '@webroot/skin/basic';

    public $baseUrl = '@web/skin/basic';


    public $depends = [
        AppAsset::class,
    ];
    
}