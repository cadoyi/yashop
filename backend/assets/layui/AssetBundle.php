<?php

namespace backend\assets\layui;

use Yii;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;
use yii\widgets\PjaxAsset;
use backend\assets\lib\LayuiAsset;


/**
 * 基本的 AssetBundle
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \backend\assets\AssetBundle
{

    public $basePath = '@webroot/skin/layui';

    public $baseUrl = '@web/skin/layui';

    public $depends = [
        JqueryAsset::class,  
        YiiAsset::class,
        PjaxAsset::class,     
        LayuiAsset::class,
    ];

}