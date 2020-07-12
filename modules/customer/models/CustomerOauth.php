<?php

namespace customer\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * oauth 认证方式登录
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerOauth extends ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer_oauth}}';
    }


    
    /**
     * @inheritdoc
     */
    public static function serializedFields()
    {
        return ['data'];
    }



    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
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
            [['customer_id', 'oauth_id'], 'required'],
            [['data'], 'safe'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }





    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                  => Yii::t('app', 'Id'),
            'customer_id'         => Yii::t('app', 'Customer id'),
            'type'                => Yii::t('app', 'Type'),
            'oauth_id'            => Yii::t('app', 'Oauth id'),
            'data'                => Yii::t('app', 'Additional data'), 
            'created_at'          => Yii::t('app', 'Created at'),
            'updated_at'          => Yii::t('app', 'Updated at'),
        ];
    }



    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);
        if($result) {
           if($insert) {
               $customer = new Customer();
               $customer->nickname = $this->username;
               if(false === $customer->save()) {
                   throw new \Exception('Customer save failed');
               }
               $this->customer_id = $customer->id;
           }
        }
        return $result;
    }

    
    /**
     * 获取 customer 关联
     * 
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, [
            'id' => 'customer_id',
        ]);
    }

}