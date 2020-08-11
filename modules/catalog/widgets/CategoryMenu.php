<?php

namespace catalog\widgets;

use Yii;
use yii\base\Widget;
use yii\widgets\Menu;
use catalog\models\widgets\Category;


/**
 * 分类导航
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryMenu extends Widget
{

    protected $_tree;


    /**
     * 获取树形结构
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
     * 获取 menu 的 items
     * 
     * @return array
     */
    public function getItems($tree = null, $level = 1)
    {
        if($tree === null) {
            $tree = $this->getTree();
        }
        $items = [];
        foreach($tree as $id => $item) {
            $items[] = $this->getItem($item, $level);
        }
        return $items;
    }   




    /**
     * 构建 menu 的 item
     * 
     * @param  array $item  数组
     * @return array
     */
    public function getItem($item, $level)
    {
         $data = [
             'label'   => $item->title,
             'url'     => ['/catalog/category/view', 'id' => $item->id],
         ];
         if($item->hasChilds()) {
             $data['items'] = $this->getItems($item->getChilds(), $level+1);            
             $data['template'] = '<a href="{url}"><span>{label}</span><i class="fa fa-angle-right"></i></a>';
            $data['submenuTemplate'] = '<div class="level-' . ($level + 1) .'"><ul>{items}</ul></div>';
         } else {
            $data['template'] = '<a href="{url}"><span>{label}</span></a>';
         }
         return $data;
    }



    /**
     * @inheritdoc
     */
    public function run()
    {
         return Menu::widget([
             'id' => $this->id,
             'items' => $this->getItems(),
         ]);
    }


}