<?php

namespace front\widgets;

use Yii;
use yii\widgets\Menu;
use front\models\Nav;

/**
 * nav menu
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class NavMenu extends Menu
{


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initItems();
    }


    /**
     * 获取树
     * 
     * @return array
     */
    protected function getTree()
    {
        $all = Nav::find()
            ->tableCache()
            ->select(['id', 'parent_id', 'title'])
            ->indexBy('id')
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();
        $tree = [];
        foreach($all as $id => $nav) {
            if(!$nav->parent_id) {
                $tree[$id] = $nav;
            } elseif(!isset($all[$nav->parent_id])) {
                continue;
            } else {
                $parent = $all[$nav->parent_id];
                if($parent->isRelationPopulated('childs')) {
                    $childs = $parent->childs;
                } else {
                    $childs = [];
                }
                $childs[] = $nav;
                $parent->populateRelation('childs', $childs);
            }
        }
        return $tree;
    }


    /**
     * 初始化 items
     */
    public function initItems()
    {
        $tree = $this->getTree();
        $this->items = $this->buildItemsFormTree($tree);
    }


    /**
     * 根据树结构构建 items
     * 
     * @param  array $tree
     * @return array
     */
    protected function buildItemsFormTree( $tree )
    {
        $items = [];
        foreach($tree as $nav) {
            $item = [
               'label' => $nav->title,
            ];
            if($nav->isRelationPopulated('childs')) {
                $item['url'] = '#';
                $item['items'] = $this->buildItemsFormTree($nav->childs);
            } else {
                $item['url'] = ['/catalog/category/view', 'id' => 29];
            }
            $items[] = $item;
        }
        return $items;
    }





}