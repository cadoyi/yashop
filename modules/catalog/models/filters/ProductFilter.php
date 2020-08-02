<?php

namespace catalog\models\filters;

use Yii;
use cando\mongodb\ActiveFilter;
use catalog\models\Product;

/**
 * 产品过滤器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductFilter extends ActiveFilter
{
    
    public $modelClass = Product::class;

    public $isDeleted = 0;



    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()
            ->andWhere(['is_deleted' => $this->isDeleted]);
    }



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {

    }

}