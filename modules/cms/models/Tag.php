<?php

namespace cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;


/**
 * cms tag
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Tag extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_tag}}';
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
           [['name'], 'unique', 'when' => function($model, $attribute) {
               return $model->isAttributeChanged($attribute);
           }]
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'name'        => Yii::t('app', 'Tag name'),
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