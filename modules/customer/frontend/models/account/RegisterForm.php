<?php

namespace customer\frontend\models\account;

use Yii;
use yii\base\DynamicModel;
use customer\models\types\Email;
use customer\models\types\Phone;


/**
 * 注册使用的 Form
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class RegisterForm extends Model
{

    const SESSION_KEY = 'register-username';


    /**
     * @var string 图片验证码
     */
    public $code;


    protected $_account;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'code'], 'required'],
            [['username'], 'compose', 'rules' => [
                    ['email'],
                    ['phone'],
                ],
                'condition' => 'or',
            ], 
            ['code', 'captcha', 'captchaAction' => '/customer/account/captcha'],
            ['username', 'validateUsername', 'skipOnError' => true],
        ];
    }       


    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'register';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username'         => Yii::t('app', 'Account'),
            'code'             => Yii::t('app', 'Verify code'),
        ];
    }




    /**
     * 验证用户名
     * 
     * @param  [type] $attribute [description]
     * @return [type]            [description]
     */
    public function validateUsername($attribute)
    {
        $exists = $this->findUsername()->exists();
        if($exists) {
            $this->addError($attribute, Yii::t('app', 'Account already exists'));
        }
    }





    /**
     * 保存用户名.
     * 
     * @return string
     */
    public function saveUsername()
    {
        Yii::$app->session->set(static::SESSION_KEY, [
            'expire'   => time() + 3600,
            'username' => $this->username,
        ]);
    }



    /**
     * 清除保存的内容.
     */
    public static function clear()
    {
        Yii::$app->session->remove(static::SESSION_KEY);
    }



    /**
     * 获取保存的用户名.
     * 
     * @return array|boolean
     */
    public static function getSavedUsername()
    {
        $data = Yii::$app->session->get(static::SESSION_KEY, []);
        $expire = $data['expire'] ?? 0;
        if(time() > $expire) {
            if(!empty($data)) {
                static::clear();
            }
            return false;
        }
        return $data['username'];
    }


}