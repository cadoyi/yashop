<?php

namespace sales\models;

use Yii;
use sales\models\db\ItemActiveRecord;
use catalog\models\Product;
use catalog\models\ProductSku;
use sales\models\order\OrderProduct;


/**
 * order item
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderItem extends ItemActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales_order_item}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }



    /**
     * @inheritdoc
     */
    public static function serializedFields()
    {
        return ['product_sku_attrs'];
    }


    /**
     * 设置 sku
     * 
     * @param string $sku
     */
    public function setSku( $sku )
    {
        $this->spu = $sku;
    }



    /**
     * 获取 sku
     * 
     * @return string
     */
    public function getSku()
    {
        return $this->spu;
    }



    /**
     * 设置 product 
     * 
     * @param Product $product   
     * @param ProductSku|null $productSku 
     */
    public function setProduct(Product $product, $productSku, $qty = 1)
    {
        $this->store_id = $product->store_id;
        $this->product_id = $product->id;
        $this->name  = $product->title;
        $this->sku   = $product->sku;
        $this->image = $product->image;
        $this->price = $product->getFinalPrice();
        $this->is_selectable = $product->is_selectable;
        $this->is_virtual = $product->is_virtual;
        if($productSku instanceof productSku) {
            $this->product_sku_id = $productSku->id;
            $this->product_sku_attrs = $productSku->attrs;
            $this->product_sku_sku = $productSku->sku;
            $this->product_sku_price = $productSku->getFinalPrice();
            $this->product_sku_image = $productSku->image;
            $this->row_total = $productSku->getFinalPrice($qty);
        } else {
            $this->row_total = $product->getFinalPrice($qty);
        }
        $this->qty_ordered = $qty;
    }



    /**
     * 获取 order 实例
     * 
     * @return sales\models\Order
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['increment_id' => 'increment_id']);
    }


    /**
     * 获取产品
     * 
     * @return order\Product
     */
    public function getOrderProduct()
    {
        return new OrderProduct($this);
    }

}