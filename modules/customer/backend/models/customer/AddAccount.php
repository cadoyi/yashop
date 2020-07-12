<?php

namespace customer\backend\models\customer;

use Yii;
use yii\base\Model;
use customer\models\Customer;
use customer\models\CustomerAccount;
use customer\models\types\Phone;
use customer\models\types\Email;

/**
 * 增加账号
 *
 * @author  zhanghang <zhangyangcado@qq.com>
 */
class AddAccount extends Model
{
    const ACCOUNT_TYPE_EMAIL = 'email';
    const ACCOUNT_TYPE_PHONE = 'phone';

    public $customer;

    public $type;


    public $username;

    public $password;

    public $password_confirm;


    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $requirePassword = $this->requirePassword();
        $requirePasswordClient = $requirePassword ? 'true' : 'false';
        return [
            [['username'], 'required'],
            [['username'], $this->usernameValidator()],
            [['password', 'password_confirm'], 'required', 'when' => function( $model, $attribute) use ($requirePassword) {
                return $requirePassword;
            }, 'whenClient' => "function() { return {$requirePasswordClient}; }" ],
            [['password', 'password_confirm'], 'string', 'length' => [6, 32]],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $usernameLabel = $this->type === 'email' ? 'Email address' : 'Mobile number';
        return [
            'username' => Yii::t('app', $usernameLabel),
            'password' => Yii::t('app', 'Password'),
            'password_confirm' => Yii::t('app', 'Confirm password'),
        ];
    }



    /**
     * 是否可以添加指定的账户.
     * 
     * @return boolean
     */
    public function canAddAccount()
    {
        switch($this->type) {
            case static::ACCOUNT_TYPE_EMAIL:
                $relation = 'typeEmail';
                break;
            case static::ACCOUNT_TYPE_PHONE:
                $relation = 'typePhone';
                break;
            default:
                throw new \Exception('Unknown account type');
        }
        return !$this->customer->$relation;
    }



    /**
     * 是否密码必填
     * 
     * @return boolean
     */
    public function requirePassword()
    {
        return !$this->customer->typePhone && !$this->customer->typeEmail;
    }



    /**
     * 用户名验证器.
     * 
     * @return string
     */
    public function usernameValidator()
    {

        switch($this->type) {
            case static::ACCOUNT_TYPE_PHONE:
                $validator =  'phone';
                break;
            default:
                $validator = 'email';
                break;
        }
        return $validator;
    }



    /**
     * 指定的账户类型是否允许
     * 
     * @return boolean 
     */
    public function isTypeValid()
    {
        switch($this->type) {
            case static::ACCOUNT_TYPE_PHONE:
            case static::ACCOUNT_TYPE_EMAIL:
               $valid = true;
               break;
            default:
               $valid = false;
               break;
        }
        return $valid;
    }



    /**
     * 保存账户.
     * 
     * @return boolean
     */
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }

        switch($this->type) {
            case static::ACCOUNT_TYPE_PHONE:
                $method = 'addPhone';
                break;
            default:
                $method = 'addEmail';
                break;
        }
        return $this->$method();
    }



    /**
     * 增加手机号账户.
     */
    public function addPhone()
    {
        $phone = new Phone([
            'customer' => $this->customer,
            'username' => $this->username,
        ]);
        if($this->password) {
            $phone->setPassword($this->password);
        } else {
            $phone->password_hash = $this->customer->typeEmail->password_hash;
        }
        return $phone->save();
    }



    /**
     * 增加 email 账户
     */
    public function addEmail()
    {
        $email = new Email([
            'customer' => $this->customer,
            'username' => $this->username,
        ]);
        if($this->password) {
            $email->setPassword($this->password);
        } else {
            $email->password_hash = $this->customer->typePhone->password_hash;
        }
        return $email->save();
    }





}