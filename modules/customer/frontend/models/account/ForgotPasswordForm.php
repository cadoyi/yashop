<?php

namespace customer\frontend\models\account;

use Yii;


/**
 * 忘记密码的表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ForgotPasswordForm extends Model
{

    public $code;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['code'], 'required'],
            [['code'], 'captcha', 'captchaAction' => 'customer/account/captcha'],
            [['username'], function($attribute) {
                if(!$this->findUsername()->exists()) {
                    return $this->addError('该用户还未注册!');
                }
            }],
        ]);
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'code'     => Yii::t('app', 'Captcha code'),
        ];
    }



    /**
     * 临时保存用户名.
     * 
     * @return boolean
     */
    public function saveUsername( $step = 1)
    {
        Yii::$app->session->set('reset-password', [
            'username' => $this->username,
            'step'   => $step,
            'expire' => time() + 3600,
        ]);
    }


    public static function setStep($step = 1)
    {
        $username = Yii::$app->session->get('reset-password', false);
        if($username) {
            $username['step'] = $step;
            Yii::$app->session->set('reset-password', $username);
        }
    }


    public static function getStep()
    {
        $username = Yii::$app->session->get('reset-password', []);
        return $username['step'] ?? 0;
    }



    /**
     * 获取保存的用户名.
     */
    public static function getSavedUsername()
    {
        $username = Yii::$app->session->get('reset-password', [
            'expire' => 0,
        ]);
        if(time() > $username['expire']) {
            return null;
        }
        return $username['username'] ?? null;
    }


    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'forgot';
    }


}