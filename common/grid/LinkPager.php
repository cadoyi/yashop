<?php

namespace common\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * 分页部分
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LinkPager extends \yii\widgets\LinkPager
{

    public $prevPageLabel = '&lt;';
    public $nextPageLabel = '&gt;';

    public $maxButtonCount = 7;

}