<?php

namespace catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;


/**
 * 产品规格值表
 *
 * @author  zhangyang   <zhangyangcado@qq.com>
 */
class ProductSpec extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_spec}}';
    }



    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                 'class' => TimestampBehavior::class,
            ],
        ]);
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id', 'attribute_id'], 'required'],
            [['product_id', 'category_id', 'attribute_id'], 'integer'],
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
            'category_id'        => 'Category',
            'attribute_id'       => 'Category attribute',
            'value'              => 'Category attribute value',
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



    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }



    public function setCategory(Category $category)
    {
        $this->category_id = $category->id;
        $this->populateRelation('category', $category);
    }



    public function setCategoryAttribute(CategoryAttribute $attribute)
    {
        $this->attribute_id = $attribute->id;
        $this->populateRelation('categoryAttribute', $attribute);
    }



    public function getCategoryAttribute()
    {
        return $this->hasOne(CategoryAttribute::class, ['id' => 'attribute_id']);
    }

}