<?php

namespace common\assets;

use Yii;


/**
 * jstree 插件
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class JsTreeAsset extends AssetBundle
{

    /**
     * @var string 资源包名
     */
    public $asset = 'jstree-3.3.10';


    public $js = [
        'dist/jstree.js',
    ];


    public $css = [
        'dist/themes/default/style.min.css',
    ];


    public $depends = [
       'yii\web\JqueryAsset',
    ];

}