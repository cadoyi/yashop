<?php

namespace sales\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use sales\models\db\ActiveRecord;


/**
 * 针对店铺的订单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderStore extends ActiveRecord
{

    
    /**
     * @inheritdoc
     */
    public static function shardingConfig()
    {
        return [
            'dbName'     => 'db',
            'dbCount'    => 1,
            'tableName'  => 'sales_order_store',
            'tableCount' => 1,
            'key'        => 'store_id',
        ];
    }



    public function rules()
    {
        return [
            [[
                'store_id', 
                'increment_id', 
                'amount_increment_id', 
                'customer_id', 
                'customer_group_id',
                'status',
            ], 'required'],
            [['store_id', 'customer_id'], 'integer'],
            [['grand_total'], 'number'],
            [['qty_ordered'], 'integer'],
            [['reviewed'], 'default', 'value' => 0],
        ];
    }


}