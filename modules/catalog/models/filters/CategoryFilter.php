<?php

namespace catalog\models\filters;

use Yii;
use cando\db\ActiveFilter;
use catalog\models\Category;

/**
 * 分类过滤器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryFilter extends ActiveFilter
{

    public $modelClass = Category::class;



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
            'and',
            ['like', 'title', $this->title],
            ['parent_id' => $this->parent_id],
        ]);
    }
    

}