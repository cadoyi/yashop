<?php

namespace customer\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 客户地址
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerAddress extends ActiveRecord
{

    public $as_default;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer_address}}';
    }




    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'name', 'phone', 'region', 'city', 'street'], 'required'],
            [['customer_id'], 'integer'],
            [['street'], 'string'],
            [['tag', 'region', 'city', 'area'], 'string', 'max' => 32],
            [['name', 'zipcode'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 16],
            [['as_default'], 'boolean'],
            [['as_default'], 'default', 'value' => 0],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }




    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'Id'),
            'customer_id' => Yii::t('app', 'Customer id'),
            'tag'         => Yii::t('app', 'Tag'),
            'name'        => Yii::t('app', 'Name'),
            'phone'       => Yii::t('app', 'Phone'),
            'region'      => Yii::t('app', 'Region'),
            'city'        => Yii::t('app', 'City'),
            'area'        => Yii::t('app', 'Area'),
            'street'      => Yii::t('app', 'Street'),
            'zipcode'     => Yii::t('app', 'Zipcode'),
            'as_default'  => Yii::t('app', 'As default address'),
            'created_at'  => Yii::t('app', 'Created at'),
            'updated_at'  => Yii::t('app', 'Updated at'),
        ];
    }


    /**
     * 设置 customer 关联
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
        return $this->hasOne(Customer::class, [
            'id' => 'customer_id',
        ]);
    }



    /**
     * 设置为默认地址.
     * 
     * @return string
     */
    public function asDefault()
    {
        $this->customer->default_address = $this->id;
        return $this->customer->save();
    }



    /**
     * 是否为默认地址
     * 
     * @return boolean
     */
    public function isDefault()
    {
        return $this->customer->default_address == $this->id;
    }



    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if(!$this->customer->default_address || $this->as_default) {
            $this->customer->default_address = $this->id;
            $this->customer->save();
            $this->as_default = null;
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    


}