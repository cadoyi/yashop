<?php

namespace wishlist\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;
use customer\models\Customer;
use catalog\models\Product;
use wishlist\models\collections\ProductCollection;

/**
 * 收藏夹
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Wishlist extends ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wishlist}}';
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
            [['customer_id'], 'integer'],
            [['customer_id'], 'exist', 'targetClass' => Customer::class, 'targetAttribute' => 'id'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
           'customer_id' => 'Customer',
        ];
    }



    
    /**
     * 获取 wishlist products
     * 
     * @return yii\db\ActiveQuery[]
     */
    public function getProducts()
    {
        return $this->hasMany(WishlistProduct::class, ['wishlist_id' => 'id'])
            ->orderBy(['id' => SORT_DESC])
            ->indexBy(['product_id'])
            ->inverseOf('wishlist');
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
        return $this->hasOne(Customer::class, ['id' => 'customer_id'])
            ->inverseOf('wishlist');
    }




    /**
     * 根据 customer 来查找
     * 
     * @param  Customer|int $customer 
     * @return $this
     */
    public static function findByCustomer($customer)
    {
        if($customer instanceof Customer) {
            $customer = $customer->id;
        }
        if(!is_numeric($customer)) {
            throw new \Exception('Customer ID invalid');
        }
        return static::findOne(['customer_id' => $customer]);
    }




    /**
     * 增加 item_count
     *
     * @param boolean $sub 是否减少.
     */
    public function addItemCount($counter = 1)
    {
        $result = static::updateAllCounters(
            ['item_count' => $counter], 
            'id = :wishlist_id', 
            [
                'wishlist_id' => $this->id,
            ]
        );
        if($result) {
            $this->item_count++; 
        }
        return $this->item_count;
    }




    /**
     * 获取产品收集器.
     * 
     * @return ProductCollection
     */
    public function getProductCollection()
    {
        return new ProductCollection(['wishlist' => $this]);
    }


    


}