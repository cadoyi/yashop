<?php

namespace catalog\widgets;

use Yii;
use yii\helpers\Html;
use yii\bootstrap4\InputWidget;
use catalog\models\widgets\Category;

/**
 * 分类选择， 只选择具体的分类。
 * 
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategorySelector extends InputWidget
{

    protected $_tree;

    public $options = [
        'class' => 'form-control'
    ];

    public $encodeSpaces = true;

    public $disableParent = true;



    /**
     * 获取分类。
     * 
     * @return array
     */
    public function getTree()
    {
        if(is_null($this->_tree)) {
            $this->_tree = Category::tree();
        }
        return $this->_tree;
    }



    /**
     * 构建分类选择的 items
     * 
     * @return 
     */
    public function buildItems(&$items, $tree = null)
    {
        if($tree === null) {
            $tree = $this->getTree();
        }
        foreach($tree as $category) {
           $items[$category->id] = $category->levelLabel;
           if($category->hasChilds()) {
               // 禁止选择父分类
               if($this->disableParent) {
                    $this->options['options'][$category->id]['disabled'] = 1;
               }
               $this->buildItems($items, $category->getChilds());
           }
        }
    }






    /**
     * 渲染选择框
     * 
     * @return string
     */
    public function renderSelect()
    {
        $items = [];
        $this->buildItems($items);
        $this->options['encodeSpaces'] = $this->encodeSpaces;
        if($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $items, $this->options);
        }
        return Html::dropDownList($this->name, $this->value, $items, $this->options);
    }

    

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->renderSelect();
    }

}