<?php

namespace customer\frontend\models\account;

use Yii;
use yii\base\DynamicModel;
use customer\models\types\Email;
use customer\models\types\Phone;


/**
 * register form
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class RegisterForm extends Model
{

    public $password;

    public $password_confirm;

    /**
     * @var string 手机号或者邮箱验证码
     */
    public $code;


    protected $_account;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'code', 'password', 'password_confirm'], 'required'],
            [['username'], 'compose', 'rules' => [
                    ['email'],
                    ['phone'],
                ],
                'condition' => 'or',
            ], 
            ['code', 'string', 'length' => 6],
            [['code'], function() {
                $code = Yii::$app->session->get('register_code');
                if(!$code || !is_array($code) || !isset($code['code'])) {
                    $this->addError('code', Yii::t('app', 'Please send captcha code first'));
                    return;
                }
                if($this->code != $code['code']) {
                    $this->addError('code', Yii::t('app', 'Captcha code error'));
                }
            }],
            [['password', 'password_confirm'], 'string', 'min' => 6],
            [['password'], 'match', 'pattern' => '/[a-zA-Z]/', 'message' => '{attribute}必须包含至少一个大小写字母'],
            [['password'], 'match', 'pattern' => '/[0-9]/', 'message' => '{attribute}必须至少包含一个数字'],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
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
            'password'         => Yii::t('app', 'Password'),
            'password_confirm' => Yii::t('app', 'Confirm password'),
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
     * 注册用户
     * 
     * @return boolean
     */
    public function register()
    {
        if(!$this->validate()) {
            return false;
        }
        if($this->isEmail()) {
            return $this->registerEmailAccount();
        }
        return $this->regiserPhoneAccount();
    }



    /**
     * 注册 email 账户
     * 
     * @return boolean
     */
    public function registerEmailAccount()
    {
        $email = new Email();
        $email->username = $this->username;
        $email->setPassword($this->password);
        if($email->save()) {
            $this->_account = $email;
            return true;
        }
        return false;
    }



    /**
     * 注册手机号账户
     * 
     * @return boolean
     */
    public function registerPhoneAccount()
    {
        $phone = new Phone();
        $phone->username = $this->username;
        $phone->setPassword($this->password);
        if($phone->save()) {
            $this->_account = $phone;
            return true;
        }
        return false;
    }


    
    /**
     * 获取 customer , 注册成功之后调用
     * 
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->_account->getIdentity();
    }




}