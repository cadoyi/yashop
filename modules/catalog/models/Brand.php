<?php

namespace catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 品牌表
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Brand extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_brand}}';
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'logo'], 'string', 'max' => 255],
            [['name'], 'unique', 'when' => function( $model, $attribute) {
                return $model->isAttributeChanged($attribute);
            }],
            [['sort_order'], 'default', 'value' => 100 ],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'Id'),
            'name'         => Yii::t('app', 'Brand name'),
            'description'  => Yii::t('app', 'Description'),
            'logo'         => Yii::t('app', 'Logo'),
            'sort_order'   => Yii::t('app', 'Sort order'),
            'created_at'   => Yii::t('app', 'Created at'),
            'updated_at'   => Yii::t('app', 'Updated at'),
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
            ->select('name')
            ->indexBy('id')
            ->tableCache()
            ->column();
    }

}