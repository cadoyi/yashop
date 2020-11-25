<?php

namespace core\widgets\pjaxmodal;

use Yii;
use yii\web\AssetBundle;

/**
 * pjax modal asset
 *
 * @author  zhangyang <zhnagyangcado@qq.com>
 */
class PjaxModalAsset extends AssetBundle
{

    public $sourcePath = '@core/widgets/pjaxmodal/assets';


    public $js = [
       'pjaxmodal.js',
    ];


    public $css = [
        'pjaxmodal.css',
    ];


    public $depends = [
       'yii\web\JqueryAsset',
    ];


    /**
     * 获取转圈圈图片
     */
    public function getLoaderUrl()
    {
        return $this->baseUrl . '/' . 'ajax-loader.gif';
    }


}