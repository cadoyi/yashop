<?php

namespace customer\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 用户名和密码方式登录
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerAccount extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer_account}}';
    }



    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ]);
    }




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['customer_id'], 'integer'],
            [['type', 'username', 'password_hash'], 'string', 'max' => 255],
            [['type', 'username'], 'unique', 
                 'targetAttribute' => ['type', 'username'], 
                 'message' => Yii::t('app', 'This {label} already exists', [
                     'label' => $this->getAttributeLabel('username'), 
                 ]),
            ],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'Id'),
            'customer_id'   => Yii::t('app', 'Customer id'),
            'type'          => Yii::t('app', 'Type'),
            'username'      => Yii::t('app', 'Username'),
            'password_hash' => Yii::t('app', 'Password hash'),
            'created_at'    => Yii::t('app', 'Created at'),
            'updated_at'    => Yii::t('app', 'Updated at'),
        ];
    }




    /**
     * 设置密码
     * 
     * @param string $password 明文密码
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->helper->get('hash')
            ->generatePasswordHash($password);
    }




    /**
     * 验证密码
     * 
     * @param  string $password 明文密码
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->helper->get('hash')->validatePassword($password, $this->password_hash);
    }




    /**
     * 设置 customer
     * 
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer_id = $customer->id;
        $this->populateRelation('customer', $customer);
    }



    /**
     * 获取 customer 关联
     * 
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }



    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);
        if($result) {
           if($insert && !$this->customer_id) {
               $customer = new Customer();
               $customer->nickname = $this->username;
               if(false === $customer->save()) {
                   throw new \Exception('Customer save failed');
               }
               $this->customer_id = $customer->id;
               $this->populateRelation('customer', $customer);
           }
        }
        return $result;
    }
    

}