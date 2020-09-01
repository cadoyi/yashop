<?php

namespace catalog\models;

use Yii;
use cando\db\ActiveRecord;


/**
 * 产品销售表
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductSales extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_sales}}';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['product_id'], 'required', 'except' => static::SCENARIO_CREATE],
           [['virtual_sales', 'sales', 'product_id'], 'integer'],
           [['sales', 'virtual_sales'], 'default', 'value' => 0],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
            'product_id'    => 'Product',
            'virtual_sales' => 'Product virtual sales',
            'sales'         => 'Product sales',
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
     * 获取销售总数
     * 
     * @param  boolean $includeVirtual  
     * @return int
     */
    public function getSalesCount( $includeVirtual = true)
    {
        if(!($sales = $this->sales)) {
            $sales = 0;
        }
        if($includeVirtual) {
            if(!($virtualSales = $this->virtual_sales)) {
                $virtualSales = 0;
            }
            $sales += $virtualSales;
        }
        return $sales;
    }


}