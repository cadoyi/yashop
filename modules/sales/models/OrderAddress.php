<?php

namespace sales\models;

use Yii;
use sales\models\db\ItemActiveRecord;
use customer\models\CustomerAddress;

/**
 * 订单地址
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderAddress extends ItemActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales_order_address}}';
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
     * 设置 customer address
     * 
     * @param CustomerAddress $address
     */
    public function setAddress(CustomerAddress $address)
    {
        $customer = $address->customer;
        $this->customer_id = $customer->id;
        $this->customer_group_id = $customer->group_id;
        $this->name = $address->name;
        $this->phone = $address->phone;
        $this->tag = $address->tag;
        $this->region = $address->region;
        $this->city = $address->city;
        $this->area = $address->area;
        $this->street = $address->street;
        $this->zipcode = $address->zipcode;
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

}