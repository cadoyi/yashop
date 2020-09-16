<?php

namespace sales\models\db;

use Yii;
use sales\models\Order;
use sales\models\OrderPaid;


/**
 * order_item, order_address, order_status_history 等通用父类.
 *
 * @author  zhangyang  <zhangyangcado@qq.com>
 */
class ItemActiveRecord extends ActiveRecord
{


    /**
     * 获取 paid id
     * 
     * @return string
     */
    public function getOrderPaid()
    {
        return $this->hasOne(OrderPaid::class, ['id' => 'order_id']);
    }



    /**
     * 设置 paid
     * 
     * @param OrderPaid $paid
     */
    public function setOrderPaid(OrderPaid $paid)
    {
        $this->paid_order_id     = $paid->id;
        $this->paid_increment_id = $paid->increment_id;
        $this->populateRelation('paid', $paid);
    }



    /**
     * 获取订单实例.
     * 
     * @return string
     */
    public function getOrder()
    {
        $this->hasOne(Order::class, ['id' => 'order_id']);
    }



    /**
     * 设置订单实例.
     * 
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order_id          = $order->id;
        $this->increment_id      = $order->increment_id;
        $this->paid_order_id     = $order->paid_order_id;
        $this->paid_increment_id = $order->paid_increment_id;
        $this->populateRelation('order', $order);
    }


}