<?php

namespace checkout\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use cando\db\ActiveRecord;
use customer\models\Customer;
use catalog\models\Product;
use catalog\models\ProductSku;
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
    public static function tableName()
    {
        return '{{%checkout_quote}}';
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
            'remote_ip' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['remote_ip'],
                    self::EVENT_BEFORE_UPDATE => ['remote_ip'],
                ],
                'value' => function( $event ) {
                    return Yii::$app->request->getUserIP();
                }
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
            [['customer_id'], 'integer'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
           'customer_id'   => 'Customer',
           'product_count' => 'Product count',
           'grand_total'   => 'Grand total',
           'qty'           => 'Inventory number',
        ];
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
     * 根据 customer 来查找
     * 
     * @param  Customer|int $customer 
     * @return $this
     */
    public static function findByCustomer(Customer $customer)
    {
        $quote = static::findOne(['customer_id' => $customer->id]);
        if($quote) {
            $quote->setCustomer($customer);
        }
        return $quote;
    }



    /**
     * 获取 quote items
     * 
     * @return yii\mongodb\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(QuoteItem::class, ['quote_id' => 'id'])
            ->indexBy('id')
            ->inverseOf('quote');
    }



    /**
     * 添加 quote item
     * 
     * @param Item $item 
     */
    public function addItem( $cartItem )
    {
        $product    = $cartItem->product;
        $productSku = $cartItem->productSku;
        $qty        = $cartItem->qty;
        return $this->addProduct($product, $productSku, $qty);
    }



    /**
     * 删除所有 item
     */
    public function truncate()
    {
        foreach($this->items as $item) {
            $item->delete();
        }
        $this->qty = 0;
        $this->product_count = 0;
        $this->grand_total = 0;
    }




    /**
     * 添加产品
     * 
     * @param Product     $product    产品
     * @param ProductSku  $productSku 产品 SKU 模型
     * @param int          $qty       库存数量
     */
    public function addProduct(Product $product, $productSku, $qty)
    {
        if(!Stock::check($product, $productSku, $qty)) {
            throw new \Exception('产品库存不足!');
        }
        $quoteItem = new QuoteItem(['quote' => $this]);
        $quoteItem->setProduct($product);
        if($productSku instanceof ProductSku) {
            $quoteItem->setProductSku($productSku);
        }
        $quoteItem->qty = $qty;
        $quoteItem->save();
        if($this->isRelationPopulated('items')) {
            $items = $this->items;
            $items[$quoteItem->id] = $quoteItem;
            $this->populateRelation('items', $items);
        }
        return $quoteItem;
    }



    /**
     * 计算总价
     */
    public function collectTotals()
    {
        $this->qty = 0;
        $this->grand_total = 0;
        $this->product_count = 0;
        foreach($this->items as $item) {
            $this->qty += $item->qty;
            $this->grand_total += $item->getGrandTotal();
            $this->product_count++;
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