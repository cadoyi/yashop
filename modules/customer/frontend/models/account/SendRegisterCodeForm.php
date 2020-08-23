<?php

namespace customer\frontend\models\account;

use Yii;


/**
 * 发送注册验证码
 *  
 */
class SendRegisterCodeForm extends SendCodeForm
{

    const EMAIL_CONFIG_ID = 'customer_register';


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['username'], 'validateUsername', 'skipOnError' => true],
        ]);
    }


    /**
     * 验证用户名.
     * 
     * @param  string $attribute  属性名
     */
    public function validateUsername( $attribute )
    {
        $exist = $this->findUsername()->exists();
        if($exists) {
            $this->addError($attribute, Yii::t('app', '{attribute} already exists', [
                'attribute' => $this->getAttributeLabel($attribute),
            ]));
        }         
    }


}