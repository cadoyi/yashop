<?php

namespace catalog\models;

use Yii;
use cando\db\ActiveRecord;


/**
 * 产品类型值存储
 *
 * @author  zhangyang   <zhangyangcado@qq.com>
 */
class ProductType extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_type}}';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'type_id', 'type_attribute_id', 'value'], 'required'],
            [['product_id', 'type_id', 'type_attribute_id'], 'integer'],
            [['value'], 'safe'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
            'product_id'         => 'Product',
            'type_id'            => 'Product type',
            'type_attribute_id'  => 'Product type attribute',
            'value'              => 'Product type attribute value',
        ];
    }



    /**
     * @inheritdoc
     */
    public static function serializedFields()
    {
        return ['value'];
    }



    /**
     * 设置 type attribute
     * 
     * @param TypeAttribute $typeAttribute 
     */
    public function setTypeAttribute(TypeAttribute $typeAttribute)
    {
        $this->type_attribute_id = $typeAttribute->id;
        $this->populateRelation('typeAttribute', $typeAttribute);
    }



    /**
     * 获取 type attribute
     * 
     * @return yii\db\ActiveQuery
     */
    public function getTypeAttribute()
    {
        return $this->hasOne(TypeAttribute::class, ['id' => 'type_attribute_id']);
    }




    /**
     * 设置产品类型.
     * 
     * @param Type $type 
     */
    public function setType( Type $type )
    {
        $this->type_id = $type->id;
        $this->populateRelation('type', $type);
    }



    /**
     * 获取产品类型
     * 
     * @return yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
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