<?php

namespace catalog\models;

use Yii;
use cando\db\ActiveRecord;


/**
 * 产品库存表
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductInventory extends ActiveRecord
{

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_inventory}}';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required', 'except' => static::SCENARIO_CREATE],
           [['qty'], 'required'],
           [['product_id', 'qty', 'qty_warning'], 'integer'],
           [['qty_warning'], 'default', 'value' => 0], 
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
            'product_id' => 'Product',
            'qty'        => 'Qty',
        ];
    }



    /**
     * 获取 product
     * 
     * @return yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }




    /**
     * 设置 product
     * 
     * @param Product $product 
     */
    public function setProduct(Product $product)
    {
        $this->product_id = $product->id;
        $this->populateRelation('product', $product);
    }



    /**
     * 是否有库存
     * 
     * @return boolean 
     */
    public function hasStock()
    {
        return $this->qty > 0;
    }



    /**
     * 扣库存.
     * 
     * @param  int $qty  库存数目
     * @return boolean
     */
    public function decrQty( $qty )
    {
        $result = static::updateAllCounters(['qty' => (int) $qty],  [
            'and',
            ['id' => $this->id],
            ['>=', 'qty', $qty],
        ]);
        return $result > 0;
    }

}