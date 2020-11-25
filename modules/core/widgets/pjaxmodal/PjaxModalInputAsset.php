<?php

namespace core\widgets\pjaxmodal;

use Yii;
use yii\web\AssetBundle;

/**
 * 注册 input asset
 * 
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class PjaxModalInputAsset extends AssetBundle
{

    public $sourcePath = '@core/widgets/pjaxmodal/assets';


    public $js = [
        'pjaxmodal-input.js',
    ];


    public $depends = [
        PjaxModalAsset::class,
    ];

}