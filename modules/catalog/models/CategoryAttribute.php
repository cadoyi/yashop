<?php

namespace catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;
use catalog\models\config\CategoryAttributeConfig;

/**
 * 分类属性.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryAttribute extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_category_attribute}}';
    }


    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->andWhere(['is_deleted' => 0]);
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
            [['name', 'input_type'], 'string', 'max' => 255],
            [['json_items'], 'string'],
            ['category_id', 'integer'],
            [['is_filterable'], 'boolean'],
            [['input_type'], 'default', 'value' => 'text'],
            [['is_filterable'], 'default', 'value' => 0],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'name'       => Yii::t('app', 'Attribute name'),
           'category_id' => Yii::t('app', 'Category'),
           'input_type' => Yii::t('app', 'Input type'),
           'json_items' => Yii::t('app', 'Option values list'),
           'is_filterable' => Yii::t('app', 'Can search on frontend'),
        ];
    }



    /**
     * 设置分类
     * 
     * @param Category $category 
     */
    public function setCategory(Category $category)
    {
        $this->category_id = $category->id;
        $this->populateRelation('category', $category);
    }



    /**
     * 获取分类.
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }



    /**
     * 获取配置.
     * 
     * @return array
     */
    public function getConfig()
    {
        return new CategoryAttributeConfig([
            'categoryAttribute' => $this,
        ]);
    }



    /**
     * 获取 input_type hash 选项.
     * 
     * @return array
     */
    public static function inputTypeHashOptions()
    {
        $model = new static();
        return $model->config->inputTypeHashOptions;
    }



    /**
     * 虚拟删除
     * 
     * @return boolean
     */
    public function virtualDelete()
    {
        $this->is_deleted = true;
        return $this->save();
    }



}