<?php

namespace sales\models;

use Yii;
use yii\base\InvalidArgumentException;
use sales\models\db\OrderActiveRecord;


/**
 * 付款订单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderPaid extends OrderActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales_order_paid}}';
    }


    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
  
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }


    

    /**
     * 生成 increment_id
     * 
     * @param  string $prefix 前缀
     */
    public function generateIncrementId($prefix)
    {
        $this->increment_id = $this->_generateIncrementId($prefix, 0);
    }



    /**
     * 获取关联的店铺订单.
     * 
     * @return yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['paid_increment_id' => 'increment_id']);
    }



    
    /**
     * 交易成功. 等幂操作
     */
    public function process()
    {
        if($this->status === static::STATUS_PROCESSING) {
            return true;
        }

        $this->status = static::STATUS_PROCESSING;
        $this->save();
        foreach($this->orders as $order) {
            $order->process();
        }
        return true;
    }



    /**
     * 交易关闭, 等幂操作.
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
        foreach($this->orders as $order) {
            $order->close();
        }
        return true;
    }


}