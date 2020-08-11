<?php

namespace front\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 菜单项目
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class MenuItem extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%front_menu_item}}';
    }


 
    /**
     * @inheritdoc
     */
    public static function serializedFields()
    {
        return ['url'];
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
           [['menu_id', 'label'], 'required'],
           [['url'], 'validateUrl'],
           [['label'], 'string', 'max' => 255],
           [['parent_id', 'menu_id', 'sort_order'], 'integer'],
           [['sort_order'], 'default', 'value' => 100],
        ];
    }


    /**
     * 验证 URL
     */
    public function validateUrl($attribute, $params, $validator)
    {

    }




    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
            'sort_order' => 'Sort order',
            'menu_id'    => 'Menu',
            'parent_id'  => 'Parent menu item',
        ];
    }




}