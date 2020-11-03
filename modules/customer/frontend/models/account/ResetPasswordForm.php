<?php

namespace customer\frontend\models\account;

use Yii;
use customer\models\Customer;

/**
 * 重置密码
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ResetPasswordForm extends Model
{

    public $password;

    public $password_confirm;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->username = ForgotPasswordForm::getSavedUsername();
        $step = (int) ForgotPasswordForm::getStep();
        if($step !== 2) {
            $this->username = false;
        }
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
     * 重置密码
     * 
     * @return boolean
     */
    public function resetPassword()
    {
        if(!$this->validate()) {
            return false;
        }
        $customer = $this->getAccount()->getIdentity();
        $trans = Customer::getDb()->beginTransaction();
        try {
            $customer->changePassword($this->password);
            $trans->commit();
            
        } catch(\Exception | \Throwable $e) {
            $trans->rollBack();
            throw $e;
        }
        ForgotPasswordForm::setStep(3);
        return true;
    }

}