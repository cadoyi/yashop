<?php

namespace sales\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use sales\models\db\ActiveRecord;


/**
 * 订单表
 * 
 * @author zhangyang <zhangyangcado@qq.com>
 */
class Order extends ActiveRecord
{
 
    /**
     * @inheritdoc
     */
    public static function shardingConfig()
    {
        return [
            'dbName'      => 'db',
            'dbCount'     => 1,
            'tableName'   => 'sales_order',
            'tableCount'  => 1,
            'key'         => 'increment_id',
            'keyValue'    => function( $keyvalue ) {
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



    /**
     * 添加订单历史
     * 
     * @param string $comment
     * @param string $status  订单状态
     */
    public function addStatusHistoryComment($comment, $status = null)
    {
        if(is_null($status)) {
            $status = $this->status;
        }
        $history = new OrderStatusHistory([
            'increment_id'        => $this->increment_id,
            'amount_increment_id' => $this->amount_increment_id,
            'status' => is_null($status) ? 'pending' : $status,
            'comment' => $comment,
        ]);
        $history->save();
        return $history;
    }



    /**
     * 同步到 store 订单
     * 
     * @return boolean
     */
    public function syncToStore()
    {
        $store = OrderStore::find()
            ->andWhere(['store_id' => $this->store_id])
            ->andWhere(['increment_id' => $this->increment_id])
            ->one();
        if(!$store) {
            $store = new OrderStore([
                'store_id'            => $this->store_id,
                'increment_id'        => $this->increment_id,
                'amount_increment_id' => $this->amount_increment_id,
            ]);
        }
        foreach($this->attributes() as $attribute) {
            $store->$attribute = $this->$attribute;
        }
        $store->save();
    }

}

