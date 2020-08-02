<?php

namespace cms\models\filters;

use Yii;
use cando\db\ActiveFilter;
use cms\models\Category;

/**
 * 分类过滤
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
            'like',
            'name',
            $this->name,
        ]);
    }

    
}