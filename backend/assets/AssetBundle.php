<?php

namespace backend\assets;

use Yii;


/**
 * asset bundle 基类
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \cando\web\AssetBundle
{

    public $basePath = '@webroot';

    public $baseUrl = '@web';

}