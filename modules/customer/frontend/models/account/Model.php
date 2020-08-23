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

    public $username;


    protected $_isEmail;

    protected $_isPhone;




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



}