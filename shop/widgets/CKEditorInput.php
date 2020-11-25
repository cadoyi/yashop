<?php

namespace shop\widgets;

use Yii;
use shop\assets\lib\CKEditorAsset;
use cando\widgets\CKEditorInput as Widget;

/**
 *  ckeditor5 input
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CKEditorInput extends Widget
{


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        CKEditorAsset::register($this->view);
    }

}