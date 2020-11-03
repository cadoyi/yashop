<?php

namespace customer\frontend\models\account;

use Yii;
use customer\jobs\ForgotPasswordEmail;


/**
 * 发送注册验证码
 *  
 */
class SendForgotPasswordCodeForm extends Model
{
    const SESSION_KEY = 'forgot-password-verify';



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
        if(!$exist) {
            $this->addError($attribute, Yii::t('app', '{attribute} not exists', [
                'attribute' => $this->getAttributeLabel($attribute),
            ]));
        }
        $savedUsername = ForgotPasswordForm::getSavedUsername();
        if(!$savedUsername || $savedUsername !== $this->$attribute) {
            $this->addError($attribute, '页面已经过期,请刷新重试');
        }
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
        $message = new ForgotPasswordEmail([
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