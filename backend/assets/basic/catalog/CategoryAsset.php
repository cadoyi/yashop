<?php

namespace backend\assets\basic\catalog;

use Yii;
use backend\assets\basic\AssetBundle;


/**
 * 分类相关的 js 和 css
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryAsset extends AssetBundle
{

    public $js = [
        'js/catalog/category.js',
    ];

    public $css = [
        'css/catalog/category.css',
    ];

}