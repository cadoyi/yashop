<?php

namespace sales\models\db;

use Yii;
use customer\models\Customer;

/**
 * 订单 active record
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
abstract class OrderActiveRecord extends ActiveRecord
{

    protected static $_sequence = [];

    const STATUS_PENDING = 'pending';

    const STATUS_PROCESSING = 'processing';

    const STATUS_COMPLETE = 'complete';

    const STATUS_COMPLETE_CONFIRMED = 'complete_confirmed';

    const STATUS_CLOSED = 'closed';


    /**
     * 状态 hash options
     * 
     * @return array
     */
    public static function statusHashOptions()
    {
        return [
            self::STATUS_PENDING            => '待付款',
            self::STATUS_PROCESSING         => '已付款',
            self::STATUS_COMPLETE           => '已发货',
            self::STATUS_COMPLETE_CONFIRMED => '已确认收货',
            self::STATUS_CLOSED             => '已关闭',
        ];
    }


    /**
     * 获取状态文本
     * 
     * @return string
     */
    public function getStatusText() 
    {
        $options = static::statusHashOptions();
        return $options[$this->status];
    }


    public static function statusComments()
    {
        return [
            self::STATUS_PENDING            => '等待付款',
            self::STATUS_PROCESSING         => '支付成功',
            self::STATUS_COMPLETE           => '已发货',
            self::STATUS_COMPLETE_CONFIRMED => '已确认收货',
            self::STATUS_CLOSED             => '已关闭',
        ];
    }



    /**
     * 获取 customer 实例.
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }




    /**
     * 设置 customer
     * 
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer_id       = $customer->id;
        $this->customer_nickname = $customer->nickname;
        $this->customer_phone    = $customer->phone;
        $this->customer_email    = $customer->email;
        $this->customer_avatar   = $customer->avatar;
        $this->customer_group_id = $customer->group_id;
        $this->populateRelation('customer', $customer);
        
    }



    /**
     * 获取 customer_id 后缀
     * 
     * @param  integer $length 后缀长度
     * @return string
     */
    public function getCustomerIdSuffix( $length = 4 )
    {
        $customerId = (string) $this->customer_id;
        $len = strlen($customerId);
        if($len > $length) {
            return substr($customerId, $len - $length);
        } elseif( $len < $length ) {
            return str_pad($customerId, $length, '0', STR_PAD_LEFT);
        } else {
            return $customerId;
        }
    }



    /**
     * 生成订单序列.
     * 
     * @param  int  $prefix   
     * @param  int $sequence
     * @return int 19 位.
     */
    protected function _generateIncrementId($prefix, $sequence)
    {
        $prefix = (string) $prefix;
        $sequence = (string) $sequence;
        $suffix = $this->getCustomerIdSuffix();
        $sequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);
        return $prefix . $sequence . $suffix;
    }



}