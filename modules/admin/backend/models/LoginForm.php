<?php

namespace modules\admin\backend\models;

use Yii;
use yii\base\Model;
use cando\web\Attempt;
use modules\admin\models\User;

/**
 * 登录表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LoginForm extends Model
{

    const SCENARIO_CAPTCHA = 'captcha';
    const ATTEMPT_KEY = 'loginForm';

    const CAPTCHA_DISABLED  = 0;
    const CAPTCHA_ALWAYS    = 1;
    const CAPTCHA_CONDITION = 2;

    /**
     * @var string 用户名
     */
    public $username;


    /**
     * @var string 密码
     */
    public $password;


    /**
     * @var boolean 记住我
     */
    public $remember;


    /**
     * @var string 验证码
     */
    public $code;


    /**
     * @var Attempt 
     */
    protected $_counter;

    
    /**
     * @var false|null|User 用户实例
     */
    protected $_user = false;


    /**
     * @var Scope  admin 配置.
     */
    protected $_config;



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        /**
        switch((int) $this->config->getValue('login/captcha/enable')) {
            case self::CAPTCHA_ALWAYS:
                $this->requireCaptcha();
                break;
            case self::CAPTCHA_DISABLED:
                break;
            default:
                $this->conditionCaptcha();
                break;            
        } **/
    }


    /**
     * 条件验证
     */
    public function conditionCaptcha()
    {
        $this->_counter = new Attempt([
             'key'        => static::ATTEMPT_KEY,
             'retryCount' => 3,
             'want' => function() {
                 $this->requireCaptcha();
             }
        ]);   
    }


    /**
     * 需要验证码
     */
    public function requireCaptcha()
    {
        $this->scenario = static::SCENARIO_CAPTCHA;
    }


    /**
     * 获取配置
     * 
     * @return cado\config\Scope
     */
    public function getConfig()
    {
        if($this->_config === null) {
            $this->_config = Yii::$app->config;
        }
        return $this->_config;
    }



    /**
     * 是否可以显示验证码
     * 
     * @return boolean
     */
    public function canDisplayCaptcha()
    {
        return $this->scenario === static::SCENARIO_CAPTCHA;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['code'], 'required', 'on' => static::SCENARIO_CAPTCHA],
            [['code'], 'captcha', 
                'captchaAction' => 'admin/account/captcha',
                'on' => static::SCENARIO_CAPTCHA,
            ],
            [['username'], 'string', 'max' =>32],
            [['username'], 'validateUsername'],
            [['password'], 'validatePassword'],
            [['remember'], 'boolean' ],
            [['remember'], 'default', 'value' => 0 ],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'username' => Yii::t('app', 'Username'),
           'password' => Yii::t('app', 'Password'),
           'code'     => Yii::t('app', 'Captcha code'),
           'remember' => Yii::t('app', 'Remember me'), 
        ];
    }



    /**
     * 验证用户名
     * 
     * @param  string $attribute 属性名
     */
    public function validateUsername($attribute)
    {
        if($this->user === null) {
            $this->addError($attribute, Yii::t('app', '{attribute} not exists'), ['attribute' => $attribute]);
        }
    }



    /**
     * 验证密码
     * 
     * @param  string $attribute 属性名
     */
    public function validatePassword($attribute)
    {
        $user = $this->user;
        if($user && !$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', '{attribute} incorrent', ['attribute' => $attribute]));
        }
    }



    /**
     * 获取用户
     * 
     * @return IndentifyInterface
     */
    public function getUser()
    {
        if(false === $this->_user) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }



    /**
     * 记住我的时间
     * 
     * @return integer
     */
    public function getRememberMeTime()
    {
        if($this->remember) {
            return 3600;
        }
        return 0;
    }




    /**
     * 尝试登陆
     * 
     * @return boolean
     */
    public function login()
    {
        if(!$this->validate()) {
            if($this->_counter) {
                $this->_counter->add();
            }
            return false;
        }
        if($this->_counter) {
            $this->_counter->remove();
        }
        $time = $this->getRememberMeTime();
        return Yii::$app->user->login($this->user, $time);
    }

    

}