<?php

namespace catalog\models;

use Yii;
use cando\db\ActiveRecord;


/**
 * 产品选项.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductOption extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_option}}';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['product_id', 'name', 'values'], 'required'],
           [['product_id', 'sort_order'], 'integer'],
           [['name'], 'string'],
           [['values'], 'each', 'rule' => ['string', 'max' => 255]],
           [['sort_order'], 'default', 'value' => 1],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
            'product_id' => 'Product',
            'name'       => 'Product option name',
            'values'     => 'Product option values',
            'sort_order' => 'Sort order',
        ];
    }




    /**
     * @inheritdoc
     */
    public static function serializedFields()
    {
        return ['values'];
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

    

}