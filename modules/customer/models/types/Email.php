<?php

namespace customer\models\types;

use Yii;
use customer\models\CustomerAccount;

/**
 * 邮件账户登录
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Email extends CustomerAccount
{

    const CUSTOMER_TYPE = 'email';
    

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
            ['username', 'email'],
        ], parent::rules() );
    }   



    /**
     * 获取邮件地址
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->username;
    }



    /**
     * 设置邮件地址
     * 
     * @param string  $email 邮件地址
     */
    public function setEmail( $email )
    {
        $this->username = $email;
    }

    


}