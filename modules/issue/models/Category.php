<?php

namespace issue\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 问题分类
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
        return '{{%issue_category}}';
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
           [['title', 'code'], 'required'],
           [['title', 'code'], 'string', 'max' => 255],
           [['code'], 'match', 'pattern' => '/^[\w_]+$/'],
           [['code'], 'unique', 'when' => function($model, $attribute) {
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
            'code'  => Yii::t('app', 'Unique code'),
            'title'      => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }




    /**
     * 虚拟删除。
     * 
     * @return boolean
     */
    public function virtualDelete()
    {
        $this->is_deleted = 1;
        return $this->save();
    }


}