<?php

namespace customer\backend\models\customer;

use Yii;
use yii\base\Model;
use customer\models\Customer;
use customer\models\types\Phone;
use customer\models\types\Email;

/**
 * 新增客户
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Create extends Model
{

    public $email;

    public $phone;

    public $nickname;

    public $password;

    public $password_confirm;


    public $customer;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'password_confirm'], 'required'],
            [['email', 'phone'], 'emailOrPhone', 'skipOnEmpty' =>false],
            ['email', 'email'],
            ['phone', 'phone'],
            [['nickname'], 'string'],
            [['password', 'password_confirm'], 'string', 'length' => [6, 32]],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
            [['email'], 'unique', 'targetClass' => Email::class, 'targetAttribute' => 'username'],
            [['phone'], 'unique', 'targetClass' => Phone::class, 'targetAttribute' => 'username'],
        ];
    }




    /**
     * 要么输入 email 要么输入 phone, 要么同时输入.
     */
    public function emailOrPhone($attribute)
    {
        if(empty($this->email) && empty($this->phone)) {
            $this->addError($attribute, '邮件地址或者手机号至少有一个存在');
        }
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'email' => Yii::t('app', 'Email address'),
           'phone' => Yii::t('app', 'Mobile number'),
           'nickname' => Yii::t('app', 'Nickname'),
           'password' => Yii::t('app', 'Password'),
           'password_confirm' => Yii::t('app', 'Confirm password'),
        ];
    }




    /**
     * 保存
     * 
     * @return string
     */
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        $trans = Customer::getDb()->beginTransaction();
        try {
            $customer_id = null;
            $customer = null;
            if($this->email) {
                $email = new Email(['username' => $this->email]);
                $email->setPassword($this->password);
                $email->save();
                $customer_id = $email->customer_id;
                $customer = $email->customer;
            }
            if($this->phone) {
                $phone = new Phone(['username' => $this->phone]);
                $phone->setPassword($this->password);
                $phone->customer_id = $customer_id;
                $phone->save();
                if(!$customer) {
                    $customer = $phone->customer;
                }
            }
            if($this->nickname) {
                $customer->nickname = $this->nickname;
                $customer->save();
            }
            $this->customer = $customer;  
            $trans->commit();  
        } catch(\Exception $e) {
            $trans->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $trans->rollBack();
            throw $e;
        }

        return true;

    }




}