<?php

namespace customer\frontend\models\account;

use Yii;
use cando\web\Attempt;

/**
 * 登录表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LoginForm extends Model
{


    const SCENARIO_CAPTCHA = 'captcha';


    /**
     * @var string 登录密码
     */
    public $password;


    /**
     * @var string 验证码
     */
    public $code;


    /**
     * @var  boolean 是否记住我
     */
    public $remember = 1;




    protected $_counter;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->_counter = new Attempt([
            'key' => 'customer_login',
            'retryCount' => 3,
            'want' => function() {
                $this->scenario = static::SCENARIO_CAPTCHA;
            }
        ]);
    }




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['code'], 'required', 'on' => static::SCENARIO_CAPTCHA],
            [['code'], 
                'captcha', 
                'on' => static::SCENARIO_CAPTCHA,
                'captchaAction' => '/customer/account/captcha',
            ],
            ['password', 'required'],
            [['remember'], 'boolean'],
            [['remember'], 'default', 'value' => 1],
            [['username'], 'validateAccount', 'skipOnError' => true],            
        ]);
    }




    /**
     * 验证账户和密码
     * 
     * @param  string    $attribute 属性名
     * @param  Validator $validator 验证器
     * @param  array     $params    附加参数
     */
    public function validateAccount($attribute, $validator, $params)
    {
        if(!$this->account || !$this->account->validatePassword($this->password)) {
            $this->addError($attribute, Yii::t('app', '{attribute} or {password} incorrent', [
                 'attribute' => $this->getAttributeLabel($attribute),
                 'password'  => $this->getAttributeLabel('password'),
            ]));
        }
    }





    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'username' => Yii::t('app', 'Account'),
           'password' => Yii::t('app', 'Password'),
           'code'     => Yii::t('app', 'Captcha code'),
           'remember' => Yii::t('app', 'Remember me'),
        ];
    }




    /**
     * 是否开启了记住我这个功能
     * 
     * @return boolean
     */
    public function rememberEnabled()
    {
        return Yii::$app->config->get('customer/login/remember_me', 1);
    }


    /**
     * 记住我的时间
     * 
     * @return int
     */
    public function rememberMeTime()
    {
        return Yii::$app->config->get('customer/login/remember_time', 7200);
    }



    /**
     * 获取登录记住我的时间
     * 
     * @return int
     */
    public function getLoginDuration()
    {
        $duration = 0;
        if($this->remember) {
           $duration = $this->rememberMeTime();
        }
        return $duration;
    }


    /**
     * 登录用户
     * 
     * @return boolean
     */
    public function login()
    {
        if(!$this->validate()) {
            $this->_counter->add();
            return false;
        }
        $this->_counter->remove();
        $time = $this->getLoginDuration();
        $customer = $this->account->getIdentity();
        return Yii::$app->user->login($customer, $time);
    }


}