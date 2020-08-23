<?php

namespace customer\frontend\models\account;

use Yii;
use yii\base\Model;


/**
 * 密码表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class PasswordForm extends Model
{

    public $customer;

    public $password;

    public $password_confirm;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'password_confirm'], 'required'],
            [['password'], 'string', 'min' => 6],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'password' => Yii::t('app', 'Password'),
           'password_confirm' => Yii::t('app', 'Confirm password'),
        ];
    }


    /**
     * 修改密码
     * 
     * @return boolean
     */
    public function changePassword()
    {
        if(!$this->validate()) {
            return false;
        }
        return $this->customer->changePassword($this->password);
    }


    
}