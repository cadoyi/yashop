<?php

namespace customer\frontend\models\account;

use Yii;
use customer\models\types\Email;
use customer\models\types\Phone;

/**
 * 注册中设置密码部分.
 * 
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class RegisterPasswordForm extends Model
{
    const REGISTERED_USERNAME_KEY = 'register-password-username';
    const REGISTERED_USERID_KEY = 'register-password-userid';

    public $password;

    public $password_confirm;



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->username = RegisterForm::getSavedUsername();
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['password', 'password_confirm'], 'required'],
            [['password'], 'string', 'max' => 255],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
        ]);
    }


    /**
     * 是否已经验证.
     * 
     * @return boolean 
     */
    public function isValidated()
    {
        return RegisterCodeForm::isValidated($this->username);
    }


    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'register';
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'password_confirm' => Yii::t('app', 'Confirm password'),
        ];
    }
    

    /**
     * 注册用户
     * 
     * @return boolean
     */
    public function register()
    {
        if(!$this->validate()) {
            return false;
        }
        $result = $this->isEmail() ? $this->registerEmailAccount() : $this->regiserPhoneAccount();
        if(!$result) {
            return false;
        }
        Yii::$app->session->set(static::REGISTERED_USERNAME_KEY, $this->username);
        Yii::$app->session->set(static::REGISTERED_USERID_KEY, $this->account->customer_id);
        return true;
    }



    /**
     * 注册 email 账户
     * 
     * @return boolean
     */
    public function registerEmailAccount()
    {
        $email = new Email();
        $email->username = $this->username;
        $email->setPassword($this->password);
        if($email->save()) {
            $this->_account = $email;
            return true;
        }
        return false;
    }



    /**
     * 注册手机号账户
     * 
     * @return boolean
     */
    public function registerPhoneAccount()
    {
        $phone = new Phone();
        $phone->username = $this->username;
        $phone->setPassword($this->password);
        if($phone->save()) {
            $this->_account = $phone;
            return true;
        }
        return false;
    }


    
    /**
     * 获取 customer , 注册成功之后调用
     * 
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->_account->getIdentity();
    }




    /**
     * 获取注册的用户名
     * 
     * @return string|null
     */
    public static function getRegisteredUsername()
    {
         return Yii::$app->session->get(static::REGISTERED_USERNAME_KEY);
    } 

    

    /**
     * 清除临时保存的数据.
     */
    public static function clear()
    {
        Yii::$app->session->remove(static::REGISTERED_USERNAME_KEY);
        Yii::$app->session->remove(static::REGISTERED_USERID_KEY);
    }


}