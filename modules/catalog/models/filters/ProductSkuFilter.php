<?php

namespace catalog\models\filters;

use Yii;
use catalog\models\ProductSku;
use cando\db\ActiveFilter;

/**
 * 产品 SKU 过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductSkuFilter extends ActiveFilter
{

    public $modelClass = ProductSku::class;

    public $product;



    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()->andWhere(['product_id' => $this->product->id]);
    }




    


}