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

    protected $_childs = [];


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
           [['url'], 'string'],
           [['label'], 'string', 'max' => 255],
           [['parent_id', 'menu_id', 'sort_order'], 'integer'],
           [['sort_order'], 'default', 'value' => 100],
        ];
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



    /**
     * 获取父菜单项
     * 
     * @return yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(static::class, ['id' => 'parent_id']);
    }


    /**
     * 获取 menu 
     * 
     * @return yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id']);
    }


    
    /**
     * 增加子菜单
     * 
     * @param static $child 
     */
    public function addChild( $child )
    {
        $this->_childs[] = $child;
        $child->populateRelation('parent', $this);
        return $this;
    }



    /**
     * 获取子菜单
     * 
     * @return array
     */
    public function childs()
    {
        return $this->_childs;
    }

}