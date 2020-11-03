<?php

namespace customer\frontend\models\account;

use Yii;


/**
 * 忘记密码的表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ForgotPasswordVerifyForm extends Model
{
    const SESSION_KEY = 'forgot-password-verify';

    public $code;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->username = ForgotPasswordForm::getSavedUsername();
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['code'], 'required'],
            [['code'], function($attribute) {
                if(!$this->validateCode($this->$attribute)) {
                    $this->addError($attribute, '验证码错误或者已过期!');
                }
            }],
        ]);
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'code'     => Yii::t('app', 'Captcha code'),
        ];
    }


    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'forgot';
    }



    /**
     * 设置当前步骤.
     *
     * @author  zhangyang <zhangyangcado@qq.com>
     */
    public function addStep()
    {
        ForgotPasswordForm::setStep(2);
    }



}