<?php

namespace checkout\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;
use catalog\models\Product;

/**
 * checkout cart item
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CartItem extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%checkout_cart_item}}';
    }



    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => TimestampBehavior::class,
        ]);
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id', 'qty'], 'required'],
            [['cart_id', 'qty'], 'integer'],
            [['product_sku'], 'string'],
            [['cart_id'], 'exist', 'targetClass' => Cart::class, 'targetAttribute' => 'id'],
            [['product_id'], 'exist', 'targetClass' => Product::class, 'targetAttribute' => '_id'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
           'qty' => 'Qty',
        ];
    }



    /**
     * 获取购物车条目
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Cart::class, ['id' => 'cart_id']);
    }



    /**
     * 获取产品
     * 
     * @return Product
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['_id' => 'product_id']);
    }


    
    /**
     * 获取 sku 模型
     * 
     * @return SkuModel
     */
    public function getSkuModel()
    {
        if(!($product = $this->product)) {
            return null;
        }
        if($this->product_sku) {
            $skuModel = $this->product->getSkuModel($this->product_sku);
            return $skuModel;
        }
        return $product;
    }



    /**
     * 获取价格
     * 
     * @return string
     */
    public function getPrice()
    {
        $skuModel = $this->skuModel;
        if(!$skuModel) {
            return null;
        }
        $price = $skuModel->getFinalPrice($this->qty);
        return $price;
    }


    
}