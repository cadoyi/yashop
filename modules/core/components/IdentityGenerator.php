<?php

namespace core\components;

use Yii;
use yii\base\Component;
use yii\redis\Connection;

/**
 * id 生成组件
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class IdentityGenerator extends Component
{

    const REDIS_ZSET_KEY = 'genid';
    

    /**
     * @var string 借助 redis 来生成自增 ID
     */
    public $redis = 'redis';


    /**
     * @var string 使用 redis 的 zset 来保存各个表的自增 ID
     */
    public $zsetKey = self::REDIS_ZSET_KEY;



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->redis = Instance::ensure($this->redis, Connection::class);
    }




    /**
     * 生成新的 ID
     * 
     * @param  string $tableName 表名称
     * @return int
     */
    public function newId( $tableName )
    {
        return $this->redis->zincrby($this->zsetKey, 1, $tableName);
    }




    
    /**
     * 生成新的 order id
     *
     * order_id 由以下内容组成:
     *    前 6 位:  年月日, 比如 200808
     *    中 6 位:  自增 ID
     *    后 6 位:  用户 ID, 分表的话可以根据后六位用户 ID 来进行分表.
     *  
     * 
     * @param  string $tableName 表名称
     * @return int
     */
    public function newOrderNumber( $tableName, $customerId )
    {
        $cid = (string) $customerId;
        $len = strlen($cid);
        if($len > 6) {
            $cid = substr($cid, $len - 6); 
        } elseif($len < 6) {
            $cid = str_pad($cid, 6, '0', STR_PAD_LEFT);
        }
        $date = date('ymd');
        $tableName = strtr($tableName, [
            '{' => '',
            '}' => '',
            '%' => '',
            '-' => '',
            '_' => '',
        ]);
        $key = strtolower($date . ':' . $tableName);
        $value = $customerId;
        $seq = (string) $this->redis->zincrby($key, 1, $value);
        if(strlen($seq) < 6) {
            $seq = str_pad($seq, 6, '0', STR_PAD_LEFT);
        }
        return $date . $seq . $cid;
    }




}