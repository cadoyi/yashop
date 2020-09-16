<?php

namespace sales\models;

use Yii;
use sales\models\Order;
use sales\models\db\ItemActiveRecord;


/**
 * 订单状态历史
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderStatusHistory extends ItemActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales_order_status_history}}';
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
     * 获取订单
     * 
     * @return sales\models\Order
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['increment_id' => 'increment_id']);
    }



    /**
     * 获取状态文本
     * 
     * @return string
     */
    public function getStatusText()
    {
        $options = Order::statusHashOptions();
        $status = $this->status;
        return $options[$status];
    }

}