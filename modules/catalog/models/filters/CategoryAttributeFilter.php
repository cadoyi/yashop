<?php

namespace catalog\models\filters;

use Yii;
use cando\db\ActiveFilter;
use catalog\models\Category;
use catalog\models\CategoryAttribute;

/**
 * 分类属性过滤器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryAttributeFilter extends ActiveFilter
{

    public $category;


    public $modelClass = CategoryAttribute::class;


    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()
            ->andWhere(['category_id' => $this->category->id]);
    }


    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
            'and',
            ['like', 'name', $this->name],
            ['like', 'input_type', $this->input_type],
            ['is_filterable' => $this->is_filterable],
        ]);
    }



    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'ca';
    }

}