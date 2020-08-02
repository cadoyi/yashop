<?php

namespace cms\backend\vms\article;

use Yii;
use cando\web\ViewModel;
use cms\models\Category;
use cms\models\Tag;


/**
 * 编辑文章
 *
 * @author zhangyang <zhangyangcado@qq.com>
 */
class EditModel extends ViewModel
{


    /**
     * 分类 hash 选项.
     * 
     * @return array
     */
    public function categoryHashOptions()
    {
        return Category::hashOptions();
    }



    /**
     * tag hash options
     *  
     * @return array
     */
    public function tagHashOptions()
    {
        return Tag::hashOptions();
    }



}