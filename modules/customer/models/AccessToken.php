<?php

namespace customer\models;

use Yii;
use yii\base\Component;

/**
 * customer access token 管理.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AccessToken extends Component
{

    const REDIS_HASH_KEY = 'customer:token';

    const REDIS_EXPIRE_KEY  = 'customer:token:expire';

    /**
     * @var integer token 有效期, 单位秒
     */
    public $timeout = 7200;


    /**
     * @var integer 每次清除的个数.
     */
    public $cleanCount = 10;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->clean();
    }



    /**
     * 获取 redis 实例.
     * 
     * @return \yii\redis\Connection
     */
    public function getRedis()
    {
        return Yii::$app->redis;
    }




    
    /**
     * 根据 accessToken 来获取 ID 值.
     * 
     * @param  string $accessToken 
     * @return int|string|null
     */
    public function getIdByAccessToken($accessToken)
    {
        $id = null;
        if($this->redis->hexists(static::REDIS_HASH_KEY, $accessToken)) {
            $id = $this->redis->hget(static::REDIS_HASH_KEY, $accessToken);
            $time = (int) $this->redis->zscore(static::REDIS_EXPIRE_KEY, $id);
            if(time() >= $time) {  // expired
                $id = null;
                $this->redis->zrem(static::REDIS_EXPIRE_KEY, $id);
                $this->redis->hdel(static::REDIS_HASH_KEY, $id, $accessToken);
            }
        }
        return $id;
    }





    /**
     * 根据 ID 来获取 Access Token
     * 
     * @param  int $id 
     * @return string
     */
    public function getAccessTokenById( $id )
    {
        $token = null;
        if($this->redis->hexists(static::REDIS_HASH_KEY, $id)) {
             $token = $this->redis->hget(static::REDIS_HASH_KEY, $id);
             $time = (int) $this->redis->zscore(static::REDIS_EXPIRE_KEY, $id);
             if(time() >= $time) {
                 $token = null;
                 $this->redis->zrem(static::REDIS_EXPIRE_KEY, $id);
                 $this->redis->hdel(static::REDIS_HASH_KEY, $id, $token);
             }
        }
        return $token;
    }



    /**
     * 生成 access token 并保持
     * 
     * @param  int $id 
     * @return string AccessToken
     */
    public function generateAccessToken( $id )
    {
        $this->removeById($id);
        do {
            $token = Yii::$app->security->generateRandomString();
        } while($this->redis->hexists(static::REDIS_HASH_KEY, $token));

        $this->redis->hset(static::REDIS_HASH_KEY, $id, $token);
        $this->redis->hset(static::REDIS_HASH_KEY, $token, $id);
        $score = time() + $this->timeout;
        $this->redis->zadd(static::REDIS_EXPIRE_KEY, $score, $id);
        return $token;
    }



    /**
     * 移除某个 id 的 token
     * 
     * @param  int $id  
     * @return boolean
     */
    public function removeById($id)
    {
        if($this->redis->hexists(static::REDIS_HASH_KEY, $id)) {
            $token = $this->redis->hget(static::REDIS_HASH_KEY, $id);
            $this->redis->zrem(static::REDIS_EXPIRE_KEY, $id);
            $this->redis->hdel(static::REDIS_HASH_KEY, $id, $token);
        }
        return true;
    }



    /**
     * 移除一些过期的 key, 每次清除指定的个数.
     * 
     * @return boolean
     */
    public function clean()
    {
        $time = time();
        $ids = $this->redis->zrangebyscore(static::REDIS_EXPIRE_KEY, '-inf', $time, 'LIMIT', 0, $this->cleanCount);
        foreach($ids as $id) {
            $this->removeById($id);
        }
        return true;
    }

} 