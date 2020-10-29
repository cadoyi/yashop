<?php

namespace customer\frontend\models\account;

use Yii;
use yii\base\Exception;
use yii\base\DynamicModel;
use customer\models\types\Phone;
use customer\models\types\Email;

/**
 * 模型基类
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Model extends \yii\base\Model
{
    const SESSION_KEY = 'MODEL';

    public $username;


    protected $_isEmail;

    protected $_isPhone;

    protected $_account = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'compose', 'rules' => [
                ['email'],
                ['phone'],
            ], 'condition' => 'or'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Email or Phone'),
        ];
    }

    

    /**
     * 是否是邮件
     * 
     * @return boolean
     */
    public function isEmail()
    {
        if(is_null($this->_isEmail)) {
            $model = new DynamicModel(['email' => $this->username]);
            $model->addRule('email', 'required');
            $model->addRule('email', 'email');
            $this->_isEmail = $model->validate();            
        }
        return $this->_isEmail;
    }
    




    /**
     * 验证是否为手机号码
     * 
     * @return boolean 
     */
    public function isPhone()
    {
        if(is_null($this->_isPhone)) {
            $model = new DynamicModel(['phone' => $this->username]);
            $model->addRule('phone', 'required');
            $model->addRule('phone', 'phone');
            $this->_isPhone = $model->validate();
        }
        return $this->_isPhone;
    }



    /**
     * 获取第一个错误消息
     * 
     * @return string
     */
    public function getErrorMessage()
    {
        $errors = $this->firstErrors;
        return reset($errors);
    }


    

    /**
     * 查找用户名的查询.
     * 
     * @return yii\db\ActiveQuery
     */
    public function findUsername()
    {
        $query = $this->isEmail() ? Email::find() : Phone::find();
        $query->andWhere(['username' => $this->username]);
        return $query;
    }


    /**
     * 获取账户
     * 
     * @return string
     */
    public function getAccount()
    {
        if($this->_account === false) {
            $this->_account = $this->findUsername()->one();
        }
        return $this->_account;
    }



    

    /**
     * 获取保存的 session 数据。
     * 
     * @return array
     */
    public function getSessionData()
    {
        $data = Yii::$app->session->get(static::SESSION_KEY, []);
        $time = $data['expire'] ?? 0;
        if(time() >= $time) {
            Yii::$app->session->remove(static::SESSION_KEY);
            return [];
        }
        return $data;
    }



    /**
     * 获取过期时间。
     * 
     * @return int 单位为秒。
     */
    public function getExpire()
    {
        return 300;
    }



    /**
     * 保存验证码。
     * 
     * @param  string $code 验证码
     * @return array
     */
    public function saveSessionData( $code, $params = [])
    {
         $data = [
             'code'   => $code,
             'expire' => time() + $this->getExpire(),
             'data'   => $params,
         ];
         Yii::$app->session->set(static::SESSION_KEY, $data);
    }




    /**
     * 生成 code
     * 
     * @return int
     */
    public function generateCode($length = 6)
    {
        $str = mt_rand(1, 9);
        while($length > 1) {
            $str .= mt_rand(0,9);
            $length--;
        }
        return $str;
    }



    /**
     * 验证发送的验证码。
     * 
     * @param  string $code  验证码
     * @return boolean
     */
    public function validateCode( $code )
    {
        $data = $this->getSessionData();
        $savedCode = (int) ($data['code'] ?? 0);
        return ($savedCode === (int) $code);
    }


 
}