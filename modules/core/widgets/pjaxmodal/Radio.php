<?php

namespace core\widgets\pjaxmodal;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;


/**
 * pjaxmodal grid 单选框
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Radio extends PjaxModalInput
{


    public $data = [1 => 'value'];

    public $link = ['/eav/attribute/index'];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->isMultiple = false;
        $this->value = key($this->data);
    }


}