<?php

namespace sales\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use sales\models\db\ActiveRecord;


/**
 * order item
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderItem extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function shardingConfig()
    {
        return [
            'dbName'     => 'db',
            'dbCount'    => 1,
            'tableName'  => 'sales_order_item',
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
    

}