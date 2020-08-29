<?php

namespace front\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 菜单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Menu extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%front_menu}}';
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
           [['name', 'code'], 'required'],
           [['name', 'code'], 'string', 'max' => 255],
           [['code'], 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z0-9_\-.]+$/'],
           [['code'], 'unique', 'when' => function( $model, $attribute) {
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
            'id'         => Yii::t('app', 'Id'),
            'name'        => Yii::t('app', 'Menu name'),
            'code'        => Yii::t('app', 'Menu code'),
            'description' => Yii::t('app', 'Menu description'),
            'created_at'  => Yii::t('app', 'Created at'),
            'updated_at'  => Yii::t('app', 'Updated at'),
        ];
    }



    /**
     * 根据 code 来查找菜单。
     * 
     * @param  string $code
     * @return static
     */
    public static function findByCode($code)
    {
        return static::findOne(['code' => $code]);
    }



    /**
     * 获取 menu items
     * 
     * @return array
     */
    public function getItems()
    {
        return $this->hasMany(MenuItem::class, ['menu_id' => 'id'])
           ->orderBy(['parent_id' => SORT_ASC, 'sort_order' => SORT_ASC, 'id' => SORT_ASC ])
           ->indexBy('id')
           ->inverseOf('menu');
    }

    

}