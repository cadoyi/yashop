<?php

namespace backend\assets\lib;

use Yii;

/**
 * lib asset bundle
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \yii\web\AssetBundle
{

    public $basePath = '@webroot/lib';

    public $baseUrl = '@web/lib';

    public $depends = [];
}