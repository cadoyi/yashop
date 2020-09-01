<?php

namespace catalog\models\filters;

use Yii;
use cando\db\ActiveFilter;
use catalog\models\Product;

/**
 * 产品过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductFilter extends ActiveFilter
{

    public $modelClass = Product::class;

    public $filterDeleted = false;


    /**
     * @inheritdoc
     */
    public function query()
    {
        if(!$this->filterDeleted) {
            return parent::query()->andWhere(['is_deleted' => 0]);
        }
        return parent::query()->andWhere(['is_deleted' => 1]);
    }



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
            'and',
            ['id' => $this->id],
            ['like', 'title', $this->title],
            ['like', 'sku', $this->sku],
            ['is_selectable' => $this->is_selectable],
        ]);
    }




    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'pf';
    }

}