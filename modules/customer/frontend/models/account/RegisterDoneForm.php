<?php

namespace customer\frontend\models\account;

use Yii;

/**
 * 注册成功,显示注册的用户.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class RegisterDoneForm extends Model
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->username = RegisterPasswordForm::getRegisteredUsername();
    }



    /**
     * 是否已经注册.
     * 
     * @return boolean
     */
    public function isRegistered()
    {
        return $this->username !== null;
    }


    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'register';
    }



    /**
     * 清除 session 中的注册字段.
     * 
     * @return boolean
     */
    public function clear()
    {
        RegisterForm::clear();
        RegisterCodeForm::clear();
        RegisterPasswordForm::clear();
    }



}