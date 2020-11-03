<?php

namespace catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 产品类型属性管理
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TypeAttribute extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_type_attribute}}';
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
            [['name', 'type_id', 'input_type'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['input_type'], 'string', 'max' => 32],
            [['values'], 'string'],
            [['is_active'], 'boolean'],
            [['type_id'], 'exist', 'targetClass'=> Type::class, 'targetAttribute' => 'id'],
            [['type_id', 'name'], 'unique', 'targetAttribute' => ['type_id', 'name']],
            [['is_active'], 'default', 'value' => 1],
        ];
    }


    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'name'       => Yii::t('app', 'Attribute name'),
            'type_id'    => Yii::t('app', 'Product type'),
            'input_type' => Yii::t('app', 'Input type'),
            'values'     => Yii::t('app', 'Pre-selected values'),
            'is_active'  => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'values' => '使用 json 格式来表示预选值',
        ];
    }



    /**
     * 获取产品类型.
     * 
     * @return yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }



    
    /**
     * input_type  hash 选项.
     * 
     * @return array
     */
    public static function inputTypeHashOptions()
    {
        $config = TypeAttributeConfig::instance();
        return $config->hashOptions();
    }



    /**
     * 获取 input type 配置
     * 
     * @return Config
     */
    public function getConfig()
    {
        return TypeAttributeConfig::instance();
    }



    /**
     * 获取 TypeConfig 配置
     * 
     * @return TypeConfig
     */
    public function getTypeConfig()
    {
        return $this->getConfig()->getInputTypeConfig($this->input_type, $this);
    }

    


}