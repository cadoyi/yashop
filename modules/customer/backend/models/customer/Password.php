<?php

namespace customer\backend\models\customer;

use Yii;
use yii\base\Model;
use customer\models\Customer;
use customer\models\types\Phone;
use customer\models\types\Email;


/**
 * 更新密码
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Password extends Model
{

    /**
     * @var Customer 实例
     */
    public $customer;

    /**
     * @var string 密码
     */
    public $password;


    /**
     * @var string 确认密码
     */
    public $password_confirm;



    /**
     * @inheritdoc 
     */
    public function rules()
    {
        return [
            [['password', 'password_confirm'], 'required'],
            [['password'], 'string', 'max' => 32],
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
     * 是否可以更改密码
     * 
     * @return boolean
     */
    public function canChangePassword()
    {
        return $this->customer->typePhone || $this->customer->typeEmail;
    }



    /**
     * 保存密码
     */
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        $trans = Customer::getDb()->beginTransaction();
        try {
            $this->customer->changePassword($this->password);
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