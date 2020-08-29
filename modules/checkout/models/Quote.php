<?php

namespace checkout\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\mongodb\ActiveRecord;
use customer\models\Customer;
use catalog\models\Product;
use catalog\helpers\Stock;

/**
 * 购物车报价表
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Quote extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'checkout_quote';
    }


    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
           '_id',
           'customer_id',
           'order_id',
           'remote_ip',
           'grand_total',
           'qty',
           'created_at',
           'updated_at',
        ];
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
            [['customer_id'], 'required'],
            [['customer_id', 'order_id'], 'integer'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [];
    }



    /**
     * 设置 customer 实例
     * 
     * @param Customer $customer
     */
    public function setCustomer($customer)
    {
        $this->customer_id = $customer->id;
        $this->populateRelation('customer', $customer);
    }


    
    /**
     * 获取 customer 实例。
     * 
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }



    /**
     * 获取 quote items
     * 
     * @return yii\mongodb\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(QuoteItem::class, ['quote_id' => '_id'])
            ->inverseOf('quote');
    }



    /**
     * 添加 quote item
     * 
     * @param Item $item 
     */
    public function addItem( $item )
    {
        $quoteItem = new QuoteItem(['quote' => $this]);
        list($product, $skuModel, $qty) = Stock::check($item->product_id, $item->product_sku, $item->qty);
        $quoteItem->product_id  = $product->id;
        $quoteItem->product_sku = $skuModel ? $skuModel->sku : null;
        $quoteItem->qty         = $item->qty;
        $result                 = $quoteItem->save();
        if($this->isRelationPopulated('items')) {
            $this->items[] = $quoteItem;
        }
        return $quoteItem;
    }




    /**
     * 添加产品
     * 
     * @param Product $product  产品
     * @param string  $skuModel  skuMode
     * @param int     $qty      库存数量
     */
    public function addProduct($product, $skuModel, $qty)
    {
        $quoteItem = new QuoteItem(['quote' => $this]);
        list($product, $skuModel, $qty) = Stock::check($product, $skuModel, $qty);
        $quoteItem->product_id   = $product->id;
        $quoteItem->product_sku  = $skuModel ? $skuModel->sku : null;
        $quoteItem->qty          = $qty;
        $result                  = $quoteItem->save();
        if($this->isRelationPopulated('items')) {
            $this->items[] = $quoteItem;
        }
        return $quoteItem;
    }



    /**
     * 计算总价
     */
    public function collectTotals()
    {
        $items = $this->items;
        $this->qty = 0;
        $this->grand_total = 0;
        foreach($items as $item) {
            $product = $item->product;
            $skuModel = $item->getSkuModel();
            $this->qty += $item->qty;
            $this->grand_total += $skuModel->getFinalPrice($item->qty);
        }
    }




    /**
     * 是否有真实的产品, 如果全都是虚拟产品,则返回 false
     * 
     * @return boolean
     */
    public function hasRealProduct()
    {
        foreach($this->items as $item) {
            $product = $item->product;
            if(!$product->is_virtual) {
                return true;
            }
        }
        return false;
    }

}