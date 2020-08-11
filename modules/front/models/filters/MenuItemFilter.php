<?php

namespace front\models\filters;

use Yii;
use cando\db\ActiveFilter;
use front\models\MenuItem;

/**
 * menu item filter
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class MenuItemFilter extends ActiveFilter
{

    public $modelClass = MenuItem::class;

    public $menu;


    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()->andWhere(['menu_id' => $this->menu->id ]);
    }



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
           'and',
           ['id' => $this->id],
           ['parent_id' => $this->parent_id],
           ['like', 'label', $this->label],
        ]);
    }
}