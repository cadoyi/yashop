<?php

namespace frontend\assets\basic;

use Yii;



/**
 * layout asset bundle
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \frontend\assets\AssetBundle
{

    public $js = [];

    public $css = [];


    public $depends = [
        LayoutAsset::class,
    ];

}