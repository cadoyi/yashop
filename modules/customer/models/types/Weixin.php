<?php

namespace customer\models\types;

use Yii;
use customer\models\CustomerOauth;


/**
 * 微信登录
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Weixin extends CustomerOauth
{


    const CUSTOMER_TYPE = 'weixin';
    

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->andWhere(['type' => static::CUSTOMER_TYPE]);
    }



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->type = static::CUSTOMER_TYPE;
    }



    /**
     * 根据 unionid 来获取客户实例.
     * 
     * @param  string $unionid  unionid 字符串
     * @return static
     */
    public static function findByUnionid($unionid)
    {
         return static::find()
            ->andWhere(['oauth_id' => $unionid])
            ->one();
    }


    
    /**
     * 设置 unionid
     * 
     * @param string $unionid
     */
    public function setUnionid( $unionid )
    {
        $this->oauth_id = $unionid;
    }


    /**
     * 获取 unionid
     * 
     * @return string
     */
    public function getUnionid()
    {
        return $this->oauth_id;
    }



}