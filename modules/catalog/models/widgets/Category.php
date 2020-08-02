<?php

namespace catalog\models\widgets;

use Yii;


/**
 * 用于构建分类树结构。
 * 
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Category extends \catalog\models\Category
{

    /**
     * @var Category 父分类
     */
    public $parent;


    /**
     * @var array Category[] 子分类
     */
    public $childs = [];

    
    /**
     * @var boolean 是否已经排序
     */
    protected $_sorted = false;



    /**
     * 增加子分类。
     * 
     * @param \catalog\models\Category $child 
     */
    public function addChild(\catalog\models\Category $child)
    {
        $child->parent = $this;
        $this->childs[] = $child;
        $this->_sorted = false;
    }


    

    /**
     * 获取排序的子分类
     * 
     * @param  boolean $sorted 是否排序
     * @return array
     */
    public function getChilds($sorted = true)
    {
        if($sorted && !$this->_sorted) {
        usort($this->childs, function($a, $b) {
            if($a->sort_order > $b->sort_order) {
                return 1;
            }
            if($a->sort_order < $b->sort_order) {
                return -1;
            }
            return $a->id < $b->id ? 1 : -1;
        });
        $this->_sorted = true;            
        }
        return $this->childs;
    }



    /**
     * 是否有 childs 
     * 
     * @return boolean 
     */
    public function hasChilds()
    {
        return !empty($this->childs);
    }



     
    /**
     * 获取所有分类，并自动构建树形结构。
     * 
     * @return array
     */
    public static function tree()
    {
        $all = static::find()
           ->tableCache()
           ->indexBy('id')
           ->all();

        $tree = [];
        foreach($all as $id => $category) {
            $parentId = $category->parent_id;
            if(is_null($parentId)) {
                $tree[$id] = $category;
                continue;
            }
            $parent = $all[$parentId];
            $parent->addChild($category);
        }
        return $tree;
    }



    /**
     * 获取 level label
     * 
     * @return string
     */
    public function getLevelLabel()
    {
        $level = $this->level;
        $label = $this->title;

        return str_repeat(" ", ($level - 1) * 4) . $label;
    }



    /**
     * 构建分类选择的 items
     * 
     * @return 
     */
    public static function buildItems(&$items, $tree = null)
    {
        if($tree === null) {
            $tree = static::tree();
        }
        foreach($tree as $category) {
           $items[$category->id] = $category->levelLabel;
           if($category->hasChilds()) {
               // 禁止选择父分类
               static::buildItems($items, $category->getChilds());
           }
        }
    }




    /**
     * hash 选项。
     * 
     * @return array
     */
    public static function hashOptions()
    {
        $items = [];
        static::buildItems($items);
        return $items;
    }


}