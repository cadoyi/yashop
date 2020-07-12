<?php

namespace customer\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 客户组
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerGroup extends ActiveRecord
{

    const DEFAULT_GROUP_ID = 1;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer_group}}';
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
           [['name'], 'required'],
           [['name'], 'string', 'max' => 32],
           [['name'], 'unique', 'when' => function($model, $attribute) {
                return $model->isAttributeChanged($attribute);
           }],
        ];
    }


    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => Yii::t('app', 'Customer group name'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }



    /**
     * hash 选项
     * 
     * @return array
     */
    public static function hashOptions()
    {
        return static::find()
           ->tableCache()
           ->select('name')
           ->indexBy('id')
           ->column();
    }
    


    /**
     * 是否可被删除
     * 
     * @return boolean
     */
    public function canDelete()
    {
        return static::DEFAULT_GROUP_ID != $this->id &&
        !$this->isDefaultGroup();
    }



    /**
     * 是否可删除
     */
    public function beforeDelete()
    {
        $result = parent::beforeDelete();
        if($result) {
            $this->resetCustomerGroups();
        }
        return $result;
    }



    /**
     * 是否为后台配置的默认组
     * 
     * @return boolean 
     */
    public function isDefaultGroup()
    {
        $default = Yii::$app->config->get('customer/group/default', static::DEFAULT_GROUP_ID);
        return $default == $this->id;
    }




    /**
     * 重置默认组
     * 
     * @return boolean
     */
    public function resetCustomerGroups()
    {
        $trans = Customer::getDb()->beginTransaction();
        try {
            foreach($this->customers as $customer) {
                $customer->resetDefaultGroup();
            }
            $trans->commit();               
        } catch(\Exception $e) {
            $trans->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $trans->rollBack();
            throw $e;
        }
        return true;
    }



    /**
     * 获取 customers 
     * 
     * @return array
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::class, [
            'group_id' => 'id',
        ]);
    }

}