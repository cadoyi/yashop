<?php

namespace catalog\backend\vms\category;

use Yii;
use cando\web\ViewModel;

/**
 * 设置 json 加载数据.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Load extends ViewModel
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
        $data['children'] = $this->hasChild($category);// ? [] : null;
        return $data;
    }




    /**
     * 是否有 child
     * 
     * @param  [type]  $category [description]
     * @return boolean           [description]
     */
    public function hasChild($category)
    {
        return $category->getChilds()->count() > 0;
    }




}