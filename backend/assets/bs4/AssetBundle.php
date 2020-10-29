<?php

namespace backend\assets\bs4;

use Yii;

/**
 * 其他 asset bundle 的基类.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \backend\assets\AssetBundle
{

    public $basePath = '@webroot/skin/bs4';

    public $baseUrl = '@web/skin/bs4';


    public $depends = [
        LayoutAsset::class,
    ];

}