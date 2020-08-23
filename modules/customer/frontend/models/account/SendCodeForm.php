<?php

namespace customer\frontend\models\account;

use Yii;
use yii\base\NotSupportedException;


/**
 * 发送验证码的表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
abstract class SendCodeForm extends Model
{
    /**
     * 邮件配置的 ID , 用于发送邮件
     */
    const EMAIL_CONFIG_ID = 'default';



    /**
     * 生成验证码
     * 
     * @return int
     */
    public function generateCode()
    {
        return rand(100000, 999999);
    }


    
    /**
     * 发送验证码
     * 
     * @return int  验证码
     */
    public function send()
    {
        $code = $this->generateCode();
        if($this->isEmail()) {
            $this->sendEmailCode($code);
        } else {
            $this->sendPhoneCode($code);
        }
        return $code;
    }




    /**
     * 发送邮箱验证码
     * 
     * @param  int $code  验证码
     */
    public function sendEmailCode( $code )
    {
        $message = Yii::t('app', 'Your captcha code is {code}', [
            'code' => $code,
        ]);
        Yii::$app->sms->sendEmailByConfig(static::EMAIL_CONFIG_ID, [
            'body'    => $message,
            'to'      => $this->username,
        ]);
    }



    /**
     * 发送手机短信
     * 
     * @param  int  $code 验证码
     */
    public function sendPhoneCode( $code )
    {
        throw new NotSupportedException('暂时不支持发送手机短信, 请更换为邮箱');
    }




}