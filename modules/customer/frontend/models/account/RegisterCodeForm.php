<?php

namespace customer\frontend\models\account;

use Yii;

/**
 * 注册中发送 手机或者邮件 验证码的表单.
 *
 * @author  zhangyang <zhangyangcado@qq.com> 
 */
class RegisterCodeForm extends Model
{
    const SESSION_KEY = 'register-code';

    const VALIDATED_SESSION_KEY = 'register-code-username';

    public $code;
    
    
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
            ['code', 'required'],
            [['code'], function($attribute) {
                if(!$this->validateCode($this->$attribute)) {
                    $this->addError($attribute, '验证码不正确或已过期!');
                }
            }],
        ]);
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
           'code'     => Yii::t('app', 'Captcha code'),
        ];
    }




    /**
     * 将用户名标记为已经验证.
     * 
     * @return boolean
     */
    public function setIsValidated()
    {
        $username = $this->username;
        Yii::$app->session->set(static::VALIDATED_SESSION_KEY, $username);
    }



    /**
     * 是否已经验证过.
     * 
     * @return boolean 
     */
    public static function isValidated($username)
    {
        if(!$username) {
            return false;
        }
        $_username = Yii::$app->session->get(static::VALIDATED_SESSION_KEY);
        return $_username === $username;
    }



    /**
     * 清除数据.
     */
    public static function clear()
    {
        Yii::$app->session->remove(static::VALIDATED_SESSION_KEY);
        Yii::$app->session->remove(static::SESSION_KEY);
    }


}