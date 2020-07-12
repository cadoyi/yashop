<?php

namespace core\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 核心配置
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Config extends ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{core_config}}';
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
            [['path'], 'required'],
            [['path'], 'string'],
            [['multiple'], 'boolean'],
            [['multiple'], 'default', 'value' => 0],
            [['value'], 'validateValue'],
            [['path'], 'unique', 'when' => function($model, $attribute) {
                return $model->isAttributeChanged($attribute);
            }],
            [['value'], 'default', 'value' => null],
        ];
    }

   

    /**
     * 验证 value
     * 
     * @param  string $attribute 属性名
     */
    public function validateValue($attribute)
    {
        $value = $this->$attribute;
        if(is_null($value) || (is_array($value) && empty($value)) || $value === '') {
            return true;
        }
        if($this->multiple) {
            if(!is_array($value)) {
                $message = Yii::t('app', '{attribute} must be an array.', [
                    'attribute' => $this->getAttributeLabel($attribute),
                ]);
                $this->addError($attribute, $message);
            }
        }        
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'path'       => Yii::t('app', 'Path'),
            'value'      => Yii::t('app', 'Value'),
            'multiple'   => Yii::t('app', 'Is multiple'),
            'created_at' => Yii::t('app', 'Created time'),
            'updated_at' => Yii::t('app', 'Updated time'),
        ];
    }



    /**
     * 是否为 multiple
     * 
     * @return  boolean 
     */
    public function getIsMultiple()
    {
        return (bool) $this->multiple;
    }



    /**
     * 是否为 multiple
     * 
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->getIsMultiple();
    }



    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        if($this->isMultiple() && !is_null($this->value)) {
            $this->value = unserialize($this->value);
        }
        return parent::afterFind();
    }



    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if($this->isMultiple() && !is_null($this->value)) {
             $this->value = serialize($this->value);
        }
        return parent::beforeSave($insert);
    }




    /**
     * 获取 path 的一部分.
     * 
     * @param  string $name  path 的名称部分
     *    支持:
     *        section
     *        fieldset
     *        field
     *        
     * @return string
     */
    public function getPathPart($name)
    {
        $paths = explode('/', $this->path);
        $keys = [
            'section'  => 0,
            'fieldset' => 1,
            'field'    => 2,
        ];
        $key = $keys[$name];
        return $paths[$key];
    }


}