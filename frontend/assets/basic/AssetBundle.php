<?php

namespace frontend\assets\basic;

use Yii;




/**
 * base asset bundle
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \frontend\assets\AssetBundle
{

    public $basePath = '@webroot/skin/basic';

    public $baseUrl = '@web/skin/basic';

    
    public $js = [
        'js/scripts.js',
    ];

    public $css = [
       'css/styles.css',
    ];
    
    public $depends = [
        AppAsset::class,
    ];

}