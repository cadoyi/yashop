<?php

namespace customer\frontend\models\account;

use Yii;
use yii\base\NotSupportedException;
use customer\models\types\Phone;
use customer\models\types\Email;

/**
 * 忘记密码的表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ForgotPasswordForm extends SendCodeForm
{

    const EMAIL_CONFIG_ID = 'customer_forgot_password';

    const SCENARIO_ACCOUNT_CODE = 'code';

    public $captcha;

    public $code;


    protected $_isUsernameExist;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['captcha'], 'required'],
            [['captcha'], 'captcha', 'captchaAction' => 'customer/account/captcha'],     
            [['code'], 'required', 'on' => static::SCENARIO_ACCOUNT_CODE],
            [['code'], 'validateCode', 'on' => static::SCENARIO_ACCOUNT_CODE],     
        ]);
    }



    /**
     * 验证发送手机验证码
     * 
     * @param  string $attribute 属性名
     */
    public function validateCode($attribute)
    {
        $code = $this->$attribute;
        $registerCode = Yii::$app->session->get('customer_forgot_code');
        if(!$registerCode) {
            $this->addError($attribute, '请先发送验证码');
            return;
        }
        if(!is_array($registerCode)) {
            $this->addError($attribute, '验证码不正确');
            return;
        }
        $_code = $registerCode['code'];
        $_username = $registerCode['username'];
        $_time = $registerCode['time'];
        if($this->username !== $_username) {
            return $this->addError($attribute, '验证码不正确');
        }
        if($_code != $code) {
            return $this->addError($attribute, '验证码不正确');
        }
        if($_time - time() > 3600) {
            return $this->addError($attribute, '验证码已过期,请重新发送');
        }
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'captcha'  => Yii::t('app', 'Captcha code'),
            'code'     => Yii::t('app', 'Captcha code'),
        ];
    }




    /**
     * 账户是否存在, 不存在不会发生验证码也不会告诉前端是否存在此账户
     * 
     * @return boolean
     */
    public function isUsernameExist()
    {
        if(is_null($this->_isUsernameExist)) {
            $this->_isUsernameExist = $this->findUsername()->exists();
        }
        return $this->_isUsernameExist;
    }



    /**
     * 获取 customer
     * 
     * @return Customer
     */
    public function getCustomer()
    {
        $account = $this->findUsername()->one();
        return $account->identity;
    }


}