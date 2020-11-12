<?php

namespace issue\models\filters;

use Yii;
use cando\db\ActiveFilter;
use issue\models\Category;


/**
 * 分类搜索
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
        return $query->andFilterWhere([
            'and',
            ['id' => $this->id ],
            ['like', 'code', $this->code],
            ['like', 'title', $this->title],
        ]);
    }

}