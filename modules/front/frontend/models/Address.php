<?php

namespace front\frontend\models;

use Yii;
use cando\db\ActiveRecord;

/**
 * 地址测试分库分表
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Address extends ActiveRecord
{
    private static $_tableIndex;
    private static $_dbIndex;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
         return 'address_' . static::$_tableIndex;
    }


    /**
     * @inheritdoc
     */
    public static function getDb()
    {
        if(static::$_dbIndex === 0 ) {
            $db = 'db';
        } else {
            $db = 'db_' . static::$_dbIndex;
        }
        return Yii::$app->get($db); 
    }


    /**
     * 首先调用它来进行分库和分表
     * 
     * @return string
     */
    private static function sharding( $key )
    {
        $tableCount = 16;
        $dbCount = 2;

        static::$_tableIndex = $key % $tableCount;
        static::$_dbIndex = intval(static::$_tableIndex / ($tableCount / $dbCount));
    }


    public static function findByCustomer($customer)
    {
        self::sharding($customer);
        return static::find()->andWhere(['customer_id' => $customer]);
    }


}