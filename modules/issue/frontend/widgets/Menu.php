<?php

namespace issue\frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use issue\models\Category;
use issue\models\Menu as MenuModel;
use issue\models\Content;
use yii\helpers\Url;

/**
 * menu
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Menu extends \yii\widgets\Menu
{

    public $code = 'customer';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_initItems();
    }


    /**
     * 构建 items
     */
    protected function _initItems()
    {
        $category = Category::findOne([
            'code' => $this->code,
        ]);
        if(!$category) {
            throw new InvalidConfigException('The category code not exist.');
        }

        $menus = MenuModel::find()
            ->andWhere(['category_id' => $category->id])
            ->andWhere(['parent_id' => 0])
            ->with('childs')
            ->all();

        $this->items = $this->_initItemsByMenus($menus);
    }




    /**
     * 构建 items
     * 
     * @param  array $menus 
     * @return array
     */
    protected function _initItemsByMenus($menus)
    {
        $items = [];
        foreach($menus as $menu) {
            $item = [
                'label' => $menu->title,
            ];
            if(!empty($menu->childs)) {
                $item['url'] = '#';
                $item['items'] = $this->_initItemsByMenus($menu->childs);
            } else {
                $item['url'] = ['/issue/issue/menu', 'id' => $menu->id];
            }
            $items[] = $item;
        }
        return $items;
    }



}
