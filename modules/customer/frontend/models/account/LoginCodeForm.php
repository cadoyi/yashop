<?php

namespace customer\frontend\models\account;

use Yii;
use customer\jobs\LoginEmail;

/**
 * 验证码登录
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LoginCodeForm extends Model
{

    const SESSION_KEY = 'loginCode';

    const SCENARIO_CODE = 'code';

    public $code;



    /**
     * @inheirtdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['code', 'required', 'on' => static::SCENARIO_CODE ],
            ['code', function($attribute) {
                if(!$this->validateCode($this->$attribute)) {
                    $this->addError($attribute, '验证码已经过期！');   
                }
            }, 'skipOnError' => true, 'on' => static::SCENARIO_CODE],
            [['code'], function($attribute) {
                $params = $this->getSessionData();
                $data = $params['data'] ?? [];
                $username = $data['username'] ?? false;
                if($username !== $this->username) {
                    return $this->addError('code', '验证码已过期');
                }
            }, 'on' => static::SCENARIO_CODE], 
        ]);
    }



    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_CODE] = [
           'code',
           'username',
        ];
        return $scenarios;
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



    /**
     * 是否可以发送。
     * 
     * @return boolean
     */
    public function canSend()
    {
        $data = $this->getSessionData();
        if(!empty($data)) {
            $time = $data['expire'] ?? 0;
            if($time === 0) {
                return true;
            }
            return time() - ($time - $this->getExpire()) > 60;             
        }
        return true;
    }



    /**
     * 是否已经达到发送上线。
     * 
     * @return boolean
     */
    public function reachedMax()
    {
        return false;
    }




    /**
     * 发送验证码
     */
    public function sendCode()
    {
        if($this->reachedMax()) {
            throw new \Exception('验证码已经到达最大发送限额！');
        }

        if(!$this->canSend()) {
            throw new \Exception('每次发送验证码需要间隔 60 秒！');
        }
        if($this->isEmail()) {
            $this->sendEmailCode();
        } else {
            $this->sendPhoneCode();
        } 
    }



    /**
     * 发送邮件验证码
     * 
     * @return boolean
     */
    public function sendEmailCode()
    {
        $code = $this->generateCode();
        $this->saveSessionData($code, [
             'username' => $this->username,
        ]);
        $message = new LoginEmail([
            'email' => $this->username,
            'code'  => $code,
        ]);
        Yii::$app->queue->push($message);
    }



    /**
     * 发送手机验证码。
     * 
     * @return boolean
     */
    public function sendPhoneCode()
    {
        $code = $this->generateCode();
        $this->saveSessionData($code, [
             'username' => $this->username,
        ]);
        throw new \Exception('暂时不支持发送手机验证码！');
    }


}