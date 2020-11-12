<?php

namespace shop\assets\basic;

use Yii;

/**
 * 基本类。
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \shop\assets\AssetBundle
{



    public $css = [];

    public $js = [];


    public $depends = [
        LayoutAsset::class,
    ];

}