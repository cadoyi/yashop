<?php

namespace catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;


/**
 * product sku
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductSku extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_sku}}';
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
            [['product_id'], 'required'],
            [['product_id', 'qty'], 'integer'],
            [['price', 'promote_price'], 'number'],
            [['image', 'sku'], 'string', 'max' => 255],
            [['attrs'], 'safe'],
            [['price'], 'default', 'value' => function($model, $attribute) {
                 return $model->product->$attribute;
            }],
            [['qty'], 'default', 'value' => 0],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
            'product_id'    => 'Product',
            'promote_price' => 'Product promotion price',
            'price'         => 'Price',
            'qty'           => 'Inventory qty',
            'image'         => 'Image',
            'sku'           => 'SKU',
        ];
    }



    /**
     * @inheritdoc
     */
    public static function serializedFields()
    {
        return ['attrs'];
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
        $qty = (int) $qty;
        $result = static::updateAllCounters(['qty' => 0 - $qty], [
            'and',
            ['id' => $this->id],
            ['>=', 'qty', $qty],
        ]);
        return $result > 0;
    }



    /**
     * 获取最终价格.
     * 
     * @return string
     */
    public function getFinalPrice($qty = 1)
    {
        return $this->price * $qty;
    }




    /**
     * 获取图片 URL
     * 
     * @param  int $width   宽度
     * @param  int $height  高度
     * @return string
     */
    public function getImageUrl($width = null, $height = null)
    {
        if($this->image) {
            return (string) Yii::$app->storage->getUrl($this->image, $width, $height);
        }
        return $this->product->getImageUrl($width, $height);
    }

}