<?php

namespace customer\frontend\models\account;

use Yii;

/**
 * 验证码登录
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LoginCodeForm extends Model
{

    const SESSION_KEY = 'login-code';

    public $code;



    /**
     * @inheirtdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['code', 'required'],
            ['code', 'validateCode', 'skipOnError' => true],
            [['username'], 'validateAccount', 'skipOnError' => true], 
        ]);
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'code' => Yii::t('app', 'Captcha code'),
        ]);
    }



    /**
     * 获取 session 数据.
     * 
     * @return array
     */
    public function getSessionData()
    {
        $data = Yii::$app->session->get(static::SESSION_KEY, []);
        $time = $data['time'] ?? 0;
        if(time() - $time > 300) {
            $data['code'] = false;
        }
        return $data;
    }



    /**
     * 发送验证码.
     */
    public function sendCode()
    {
        if($this->isEmail()) {
            
        }
    }



    /**
     * 验证验证码
     * 
     * @param  string $attribute 属性名
     */
    public function validateCode($attribute)
    {
        $code = $this->$attribute;
        $params = $this->getSessionData();
        $_code = $params['code'] ?? false;
        if($code !== $_code) {
            $this->addError($attribute, '验证码已过期!');
        }
    }



    /**
     * 验证账户
     * 
     * @param  string $attribute 属性名
     */
    public function validateAccount($attribute)
    {
        $account = $this->account;
        if(!$account) {
            return $this->addError($attribute, '用户不存在!');
        }
        $params = $this->getSessionData();
        $username = $params['username'] ?? false;
        if($username !== $this->username) {
            return $this->addError('code', '验证码已过期');
        }

    }


    /**
     * 登录用户
     * 
     * @return boolean
     */
    public function login()
    {
        if(!$this->validate()) {
            return false;
        }
        $time = 0;
        $customer = $this->account->getIdentity();
        return Yii::$app->user->login($customer, $time);
    }



}