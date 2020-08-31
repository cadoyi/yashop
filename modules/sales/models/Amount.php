<?php

namespace sales\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use sales\models\db\ActiveRecord;
use customer\models\Customer;

/**
 * 订单总表. 付款使用的表.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Amount extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function shardingConfig()
    {
        return [
            'dbName'     => 'db',
            'dbCount'    => 1,
            'tableName'  => 'sales_amount',
            'tableCount' => 1,
            'key'        => 'increment_id',
            'keyValue'   => function( $keyvalue ) {
                $id = (string) $keyvalue;
                $len = strlen($id);
                return $len <= 6 ? $id : substr($id, $len - 6);
            }
        ];
    }


    
    /**
     * 生成 increment id
     */
    public function generateIncrementId()
    {
        if($this->isNewRecord && $this->customer_id && !$this->increment_id) {
            $this->increment_id = Yii::$app->genid->newOrderNumber($this->_getTableName(), $this->customer_id);
        }
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
            [['increment_id', 'customer_id', 'customer_group_id', 'quote_id'], 'required'],
            [['customer_id', 'customer_group_id', 'increment_id'], 'integer'],
            [['quote_id'], 'string'],
            [['grand_total'], 'number'],
            [['qty_ordered'], 'integer'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
            'customer_id'       => 'Customer',
            'customer_group_id' => 'Customer group',
            'increment_id'      => 'Order number',
            'quote_id'          => 'Checkout quote',
            'grand_total'       => 'Grand total',
            'qty_ordered'       => 'Qty ordered',
        ];
    }


    
    /**
     * 根据 customer 来查找订单.
     * 
     * @param  Customer|int $customer  客户或者客户 ID
     * @return $this
     */
    public static function findCustomer($customer)
    {
        if($customer instanceof Customer) {
            $customerId = $customer->id;
        } else {
            $customerId = $customer;
        }
        return static::findCustomerId($customerId);
    }


    /**
     * 设置 cusotmer, 这个要在保存之前调用.
     * 
     * @param Customer $customer 
     */
    public function setCustomer(Customer $customer)
    {
         $this->customer_id = $customer->id;
         $this->customer_group_id = $customer->group_id;
         $this->populateRelation('customer', $customer);
         $this->generateIncrementId();
    }



    /**
     * 获取 customer 实例.
     * 
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }


}