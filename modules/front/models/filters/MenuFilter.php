<?php

namespace front\models\filters;

use Yii;
use cando\db\ActiveFilter;
use front\models\Menu;


/**
 * 菜单过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class MenuFilter extends ActiveFilter
{

    public $modelClass = Menu::class;



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
            'and',
            ['id' => $this->id],
            ['like', 'name', $this->name],
            ['like', 'code', $this->code],
        ]);
    }

}