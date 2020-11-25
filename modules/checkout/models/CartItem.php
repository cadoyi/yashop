<?php

namespace checkout\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;
use catalog\models\Product;
use catalog\models\ProductSku;

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
            [['product_sku_id'], 'integer'],
            [['cart_id'], 'exist', 'targetClass' => Cart::class, 'targetAttribute' => 'id'],
            [['product_id'], 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
            [['product_sku_id'], 'exist', 'targetClass' => ProductSku::class, 'targetAttribute' => 'id'],
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
     * 设置 cart
     * 
     * @param Cart $cart 
     */
    public function setCart(Cart $cart)
    {
        $this->cart_id = $cart->id;
        $this->populateRelation('cart', $cart);
    }



    /**
     * 获取产品
     * 
     * @return Product
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
     * 获取产品 sku
     * 
     * @return ProductSku
     */
    public function getProductSku()
    {
        return $this->hasOne(ProductSku::class, ['id' => 'product_sku_id']);
    }

 
    
    /**
     * 设置 product sku
     * 
     * @param ProductSku $productSku 
     */
    public function setProductSku(ProductSku $productSku)
    {
        $this->product_sku_id = $productSku->id;
        $this->populateRelation('productSku', $productSku);
    }



        
}