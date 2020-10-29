<?php

namespace customer\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

/**
 * 手机号登录验证码
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LoginPhone extends BaseObject implements JobInterface
{

    /**
     * @var string 手机号码
     */
    public $phone;


    /**
     * @var int 验证码
     */
    public $code;


    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
         
    }

}