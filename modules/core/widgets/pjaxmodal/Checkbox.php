<?php

namespace core\widgets\pjaxmodal;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;


/**
 * pjaxmodal grid 多选框
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Checkbox extends PjaxModalInput
{


    public $data = [
        1 => 'value1', 
        2 => 'value2',
        3 => 'value3',
        4 => 'valueasdfadfasfdafa',
        5 => 'asdfadfasfdadf',
        6 => 'asdffffffffffffffff',
        7 => 'value7',
        8 => '123rweqrqwreqrew',
        9 => 'adfafdafdsafasfddasfdadsfsdafassfddasfsafsadfsdafd',
        10 => 'asdfafdafaf',
        11 => 'value11',
        12 => 'value12',
    ];

    public $link = ['/eav/attribute/index'];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->isMultiple = true;
        $this->value = array_keys($this->data);
    }


}