<?php

namespace catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 产品类型
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Type extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_type}}';
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
            [['name', 'category_id'], 'required'],
            [['category_id'], 'integer'],
            [['category_id'], 'exist', 
                'targetClass' => Category::class, 
                'targetAttribute' => 'id'
            ],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'Id'),
            'name'        => Yii::t('app', 'Product type name'),
            'category_id' => Yii::t('app', 'Category name'),
            'created_at'  => Yii::t('app', 'Created at'),
            'updated_at'  => Yii::t('app', 'Updated at'),
        ];
    }

    


    /**
     * 获取产品类型属性.
     * 
     * @return yii\db\ActiveQuery[]
     */
    public function getTypeAttributes()
    {
        return $this->hasMany(TypeAttribute::class, ['type_id' => 'id']);
    }



    /**
     * 获取激活的 type attributes
     * 
     * @return yii\db\ActiveQuery[]
     */
    public function getActivedTypeAttributes()
    {
        return $this->hasMany(TypeAttribute::class, ['type_id' => 'id'])
           ->andWhere(['is_active' => 1]);
    }


    
    /**
     * 获取分类
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCategory()
    {
         return $this->hasOne(Category::class, ['id' => 'category_id']);
    }




    /**
     * 分类对应的 type hash options
     * 
     * @param  Category $category 
     * @return array
     */
    public static function hashOptions()
    {
        return static::find()
                ->select(['name'])
                ->indexBy('id')
                ->tableCache()
                ->column();
    }






}