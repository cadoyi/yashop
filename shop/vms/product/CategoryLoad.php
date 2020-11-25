<?php

namespace shop\vms\product;

use Yii;
use cando\web\ViewModel;

/**
 * 分类加载。
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryLoad extends ViewModel
{

    
    public $categories;



    /**
     * 获取 json 数组.
     * 
     * @return array
     */
    public function toArray()
    {
        $data = [];
        foreach($this->categories as $category) {
            $data[] = $this->getJsonData($category);
        }            
        return $data;
    }



    /**
     * 获取一个分类的 json 数据.
     * 
     * @param  Category $category
     * @return array
     */
    public function getJsonData( $category )
    {
        $data = $category->toArray();
        $data['text'] = $category->title;
        $data['children'] = $category->hasChild();
        return $data;
    }

}