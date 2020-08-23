<?php

namespace customer\frontend\models\center;

use Yii;
use yii\base\Model;

/**
 * 密码表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class PasswordForm extends Model
{

    public $password;

    public $password_confirm;

    public $original_password;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['password', 'password_confirm', 'original_password'], 'required'],
           [['password', 'password_confirm'], 'string', 'min' => 6],
           [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
           [['original_password'], 'string'],
           [['original_password'], 'validateOriginPassword'],
        ];
    }



    
    /**
     * 验证原始密码
     */
    public function validateOriginPassword($attribute)
    {
        $password = $this->$attribute;
        $customer = Yii::$app->user->identity;
        if($account = $customer->typeEmail) {
        } else {
            $account = $customer->typePhone;
        }
        if(!$account) {
            $this->addError($attribute, 'No account can change password');
            return;
        }
        if(!$account->validatePassword($password)) {
            $this->addError($attribute, '{attribute} incorrent', [
                'attribute' => $this->getAttributeLabel($attribute),
            ]);
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password'          => Yii::t('app', 'Password'),
            'password_confirm'  => Yii::t('app', 'Confirm password'),
            'original_password' => Yii::t('app', 'Original password'),
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
        return Yii::$app->user->identity->changePassword($this->password);
    }



}