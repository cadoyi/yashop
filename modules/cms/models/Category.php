<?php

namespace cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;


/**
 * cms category 
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Category extends ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_category}}';
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
           [['name'], 'string', 'max' => 255],
           [['description'], 'string'],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'name'        => Yii::t('app', 'Category name'),
           'description' => Yii::t('app', 'Category description'),
           'created_at'  => Yii::t('app', 'Created at'),
           'updated_at'  => Yii::t('app', 'Updated at'),
        ];
    }




    /**
     * hash 选项.
     * 
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