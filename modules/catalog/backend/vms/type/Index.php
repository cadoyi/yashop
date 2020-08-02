<?php

namespace catalog\backend\vms\type;

use Yii;
use cando\web\ViewModel;
use catalog\models\Category;

/**
 * index
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Index extends ViewModel
{

    protected $_categoryHashOptions;


    public function getCategoryHashOptions()
    {
        if(is_null($this->_categoryHashOptions)) {
            $this->_categoryHashOptions = Category::hashOptions();
        }
        return $this->_categoryHashOptions;
    }

}