<?php

namespace core\helpers;

use Yii;

/**
 * 专门做 hash 使用
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class HashHelper extends Helper
{



    /**
     * 生成密码 hash
     * 
     * @param  string $password 明文密码
     * @return string 加密后的密码.
     */
    public function generatePasswordHash($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }



    /**
     * 生成随机的密码
     * 
     * @return string
     */
    public function generateRandomPasswordHash()
    {
        $password = Yii::$app->security->generateRandomString(32);
        return $this->generatePasswordHash($password);
    }



    /**
     * 验证密码是否正确
     * 
     * @param  string $password 明文密码
     * @param  string $hash     加密后的密码
     * @return boolean
     */
    public function validatePassword($password, $hash)
    {
        return Yii::$app->security->validatePassword($password, $hash);
    }



    /**
     * 生成 auth key
     * 
     * @return string
     */
    public function generateAuthKey()
    {
        return Yii::$app->security->generateRandomString(32);
    }



}