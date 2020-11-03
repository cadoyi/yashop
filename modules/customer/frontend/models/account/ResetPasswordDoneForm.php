<?php

namespace customer\frontend\models\account;

use Yii;

/**
 * 重置成功
 *
 * 
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ResetPasswordDoneForm extends Model
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->username = ForgotPasswordForm::getSavedUsername();
        $step = (int) ForgotPasswordForm::getStep();
        if($step !== 3) {
            $this->username = false;
        }
    }



    /**
     * 清除 session 
     */
    public function clear()
    {
        Yii::$app->session->remove('reset-password');
    }

}