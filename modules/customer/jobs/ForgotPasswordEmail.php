<?php

namespace customer\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

/**
 * 使用队列发送 email 登录验证码。
 * 
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ForgotPasswordEmail extends BaseObject implements JobInterface
{

    /**
     * @var string 邮件地址。
     */
    public $email;

    /**
     * @var int 验证码。
     */
    public $code;


    /**
     * @var string 验证码标题。
     */
    public $subject = '您正在找回 Yashop 的用户密码';



    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $mailer = Yii::$app->mailer;
        $mailer->compose()
            ->setTo($this->email)
            ->setHtmlBody('<p>您的验证码是： '. $this->code . '</p>')
            ->setSubject($this->subject)
            ->send();
    }

}