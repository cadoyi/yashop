<?php

namespace cms\backend\vms\article;

use Yii;
use cando\web\ViewModel;
use cms\models\Category;

/**
 * index view model
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class IndexModel extends ViewModel
{

    protected $_categoryHashOptions;


    /**
     * 分类过滤器.
     * 
     * @return array
     */
    public function categoryFilters()
    {
        if(is_null($this->_categoryHashOptions)) {
            $this->_categoryHashOptions = Category::hashOptions();
        }
        return $this->_categoryHashOptions;
    }



    /**
     * 获取分类名称.
     * 
     * @param  Article $article
     * @return string
     */
    public function getCategoryName($article)
    {
        $hashOptions = $this->categoryFilters();
        $key = $article->category_id;
        return $hashOptions[$key];
    }


}