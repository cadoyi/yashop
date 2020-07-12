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



}