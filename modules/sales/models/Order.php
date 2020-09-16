<?php

namespace sales\models;

use Yii;
use sales\models\db\OrderActiveRecord;
use store\models\Store;


/**
 * 订单表
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Order extends OrderActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales_order}}';
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
        return [
            'increment_id' => '订单号',
            'grand_total'  => '支付金额',
            'customer_nickname' => Yii::t('app', 'Nickname'),
            'status'       => '订单状态',
        ];
    }



    /**
     * 获取 paid id
     * 
     * @return string
     */
    public function getOrderPaid()
    {
        return $this->hasOne(OrderPaid::class, ['id' => 'paid_order_id']);
    }




    /**
     * 设置 paid
     * 
     * @param OrderPaid $paid
     */
    public function setOrderPaid(OrderPaid $paid)
    {
        $this->paid_order_id = $paid->id;
        $this->paid_increment_id = $paid->increment_id;
        $this->populateRelation('paid', $paid);
    }



    /**
     * 将订单状态写入到状态历史表中去.
     * 
     * @param string $status 订单状态.
     */
    public function addStatusToHistory($comment = null)
    {
        $history = new OrderStatusHistory(['order' => $this]);
        $history->status = $this->status;
        if(is_null($comment)) {
            $comments = static::statusComments();
            if(isset($comments[$history->status])) {
                $comment = $comments[$history->status];
            }
        }
        $history->comment = $comment;
        $history->save();
    }



    /**
     * 更改为交易处理状态.
     * 
     * @return boolean
     */
    public function process()
    {
        if($this->status === static::STATUS_PROCESSING) {
            return true;
        }
        $this->status = static::STATUS_PROCESSING;
        $this->save();
        $this->addStatusToHistory('支付成功');
        return true;
    }


    
    /**
     * 交易关闭.
     * 
     * @return boolean
     */
    public function close()
    {
        if($this->status === static::STATUS_CLOSED) {
            return true;
        }
        $this->status = static::STATUS_CLOSED;
        $this->save();
        $this->addStatusToHistory('交易关闭');
        return true;
    }



    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if($insert) {
            $this->addStatusToHistory();
        }
    }




    /**
     * 生成 increment_id
     * 
     * @param  string $prefix 前缀
     */
    public function generateIncrementId($prefix, $sequence)
    {
        $this->increment_id = $this->_generateIncrementId($prefix, $sequence);
    }


    
    /**
     * 是否已经支付.
     * 
     * @return boolean 
     */
    public function isPaided()
    {
        return $this->orderPaid->status === self::STATUS_PROCESSING;
    }




    /**
     * 获取 store
     * 
     * @return yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }



    /**
     * 获取地址
     * 
     * @return yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(OrderAddress::class, ['increment_id' => 'increment_id'])
            ->inverseOf('order');
    }



    
    /**
     * 获取 order items
     * 
     * @return yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['increment_id' => 'increment_id'])
            ->inverseOf('order');
    }



    /**
     * 获取状态历史
     * 
     * @return array
     */
    public function getStatusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class, ['increment_id' => 'increment_id'])
            ->inverseOf('order');
    }


}