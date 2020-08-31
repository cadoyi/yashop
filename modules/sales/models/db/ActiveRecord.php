<?php

namespace sales\models\db;

use Yii;
use cando\db\ShardingTrait;


/**
 * active record 基类
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
abstract class ActiveRecord extends \cando\db\ActiveRecord
{
    use ShardingTrait;




    /**
     * 根据 increment id 来查找
     * 
     * @param  string $incrementId 
     * @return yii\db\ActiveQuery
     */
    public static function findIncrementId( $incrementId )
    {
        return static::findSharding($incrementId);
    }



    /**
     * 根据 amount_increment_id 来查找
     * 
     * @param  int  $incrementId 
     * @return yii\db\AcitveQuery
     */
    public static function findAmountIncrementId( $incrementId )
    {
        return static::findSharding($incrementId, 'amount_increment_id');
    }



    /**
     * 根据 customer_id 来查询
     * 
     * @param  int  $customerId  客户 ID
     * @return yii\db\ActiveQuery
     */
    public static function findCustomerId( $customerId )
    {
        return static::findSharding($customerId, 'customer_id');
    }

    



    /**
     * 生成 ID 值
     */
    public function generateId()
    {
        $tableName = $this->_getTableName();
        $this->id = Yii::$app->genid->newId($tableName);
    }



    /**
     * 获取表名
     *
     * @return  string 表名
     */
    protected function _getTableName()
    {
        $config = static::shardingConfig();
        return $config['tableName'];
    }

}