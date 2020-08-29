<?php

namespace front\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\widgets\Menu as BaseMenu;
use front\models\Menu as MenuModel;
use front\models\MenuItem as ItemModel;

/**
 * 菜单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Menu extends BaseMenu
{

    /**
     * @var string 菜单代码
     */
    public $code;


    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if(!isset($this->code)) {
            throw new InvalidConfigException('The code property must be set');
        }
        $this->initItems();
    }



    /**
     * 初始化 items
     * 
     * @return array
     */
    public function initItems()
    {
        if(!empty($this->items)) {
            return;
        }
        $menu = MenuModel::findByCode($this->code);
        if(!$menu) {
            throw new InvalidConfigException('The menu not exist');
        }
        $tree = $this->getMenuTree($menu);
        $this->items = $this->buildMenuItems( $tree );
    }


    
    /**
     * 构建菜单子项目
     * 
     * @param  array $tree 
     */
    public function buildMenuItems( $tree )
    {
        $_items = [];
        foreach($tree as $id => $item) {
            $_items[] = $_item = [
                'label' => $item->label,
                'url'   => $item->url,
            ];
            $childs = $item->childs();
            if(!empty($childs)) {
                $_items['childs'] = $this->buildMenuItems($childs);
            }
        }
        return $_items;
    }


    
    /**
     * 获取菜单树
     * 
     * @param  Menu $menu
     */
    public function getMenuTree( $menu )
    {
        $items = $menu->items;
        $tree = [];
        foreach($items as $id => $item) {
            $parentId = $item->parent_id;
            if(!$parentId) {
                $tree[$id] = $item;
            } else {
                $parent = $items[$parentId];
                $parent->addChild($item);
            }
        }
        return $tree;
    }

}