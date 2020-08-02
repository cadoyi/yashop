<?php

namespace catalog\backend\vms\category;

use Yii;
use cando\web\ViewModel;
use catalog\models\Category;

/**
 * 编辑分类
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Edit extends ViewModel
{


    protected $_categoryHashOptions;



    /**
     * 获取分类 hash 选项.
     * 
     * @return array
     */
    public function getCategoryHashOptions()
    {
        if(is_null($this->_categoryHashOptions)) {
            $this->_categoryHashOptions = Category::hashOptions();
        }
        return $this->_categoryHashOptions;
    }

}