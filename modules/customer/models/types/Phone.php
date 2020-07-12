<?php

namespace customer\models\types;

use Yii;
use customer\models\CustomerAccount;

/**
 * 手机号码登录
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Phone extends CustomerAccount
{


    const CUSTOMER_TYPE = 'phone';
    

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
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge([
            ['username', 'phone'],
        ], parent::rules() );
    }   



    /**
     * 设置手机号码
     * 
     * @return string
     */
    public function getPhone()
    {
        return $this->username;
    }



    /**
     * 获取手机号码
     * 
     * @param string  $phone 手机号码
     */
    public function setPhone( $phone )
    {
        $this->username = $phone;
    }


}