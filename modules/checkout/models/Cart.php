<?php

namespace checkout\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;
use customer\models\Customer;

/**
 * 购物车模块
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Cart extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%checkout_cart}}';
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
           [['customer_id'], 'required'],
           [['customer_id'], 'integer'],
           [['customer_id'], 'exist', 'targetClass' => Customer::class, 'targetAttribute' => 'id'],
        ];
    }



    /**
     * 获取 items
     * 
     * @return yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id'])
            ->indexBy('id')
            ->inverseOf('cart');
    }



    /**
     * 添加购物车条目
     * 
     * @param Product $product 产品实例
     * @param SkuModel $sku    sku 模型
     * @param int  $qty        购买数量
     */
    public function addItem($product, $sku, $qty)
    {
        $newItem = null;
        foreach($this->items as $item) {
            if($item->product_id == $product->id) {
                if($sku && $item->product_sku == $sku->sku) {
                    $newItem = $item;
                    break;
                }
            }
        }
        if($newItem === null) {
            $newItem = new CartItem([
               'cart_id'     => $this->id,
               'product_id'  => $product->id,
               'product_sku' => $sku->sku,
               'qty'         => 0,
            ]);
        }
        $newItem->populateRelation('cart', $this);
        $newItem->qty += $qty;
        if(false === $newItem->save()) {
            throw new \Exception('Cart item cannot added');
        }
        return true;
    }



    /**
     * 删除购物车中的所有条目
     * 
     * @return boolean
     */
    public function removeAllItems()
    {
        foreach($this->items as $item) {
            $item->delete();
        }
        return true;
    }




    /**
     * 设置 customer
     * 
     * @param Customer $customer 
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer_id = $customer->id;
        $this->populateRelation('customer', $customer);
    }


    /**
     * 获取 customer
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }



    /**
     * 根据 customer 或者 customer_id 来获取 cart
     * 
     * @param  int|Customer $customer 
     * @return static
     */
    public static function findByCustomer($customer)
    {
        if($customer instanceof Customer) {
            $customerId = $customer->id;
        } else {
            $customerId = $customer;
        }
        return static::findOne(['customer_id' => $customerId]);
    }




}