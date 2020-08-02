<?php

namespace catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 分类表
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Category extends ActiveRecord
{

    protected $_changedPath = false;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_category}}';
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
           [['title'], 'required'],
           [['path'], 'string'],
           [['level'], 'integer'],
           [['parent_id'], 'exist', 'targetClass' => static::class, 'targetAttribute' => 'id'],
           [['sort_order'], 'default', 'value' => 1 ],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id'  => Yii::t('app', 'Parent category'),
            'title'      => Yii::t('app', 'Title'),
            'path'       => Yii::t('app', 'Category tree path'),
            'level'      => Yii::t('app', 'Category tree level'),
            'sort_order' => Yii::t('app', 'Sort order'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }







    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->afterParentChanged();
    }



    /**
     * 修改 path 和 level 到正确的级别.
     * 
     * @return boolean
     */
    public function afterParentChanged()
    {
        if($this->_changedPath) return true;
        $this->_changedPath = true;
        $this->refresh();
        $parent = $this->parent;
        if(is_null($parent)) {
            $this->path = $this->id;
            $this->level = 1;
        } else {
            $this->path = $parent->path . '/' . $this->id;
            $this->level = $parent->level + 1;
        }
        $result = $this->save(false);
        $this->_changedPath = false;
        return $result;
    }



    /**
     * 获取父分类.
     * 
     * @return string
     */
    public function getParent()
    {
        return $this->hasOne(static::class, ['id' => 'parent_id']);
    }



    /**
     * 获取子分类
     * 
     * @return array
     */
    public function getChilds()
    {
        return $this->hasMany(static::class, ['parent_id' => 'id'])
           ->orderBy(['sort_order' => SORT_ASC ]);
    }

    


    /**
     * 分类 hash 选项.
     * 
     * @return array
     */
    public static function hashOptions()
    {
        return static::find()
           ->select(['title'])
           ->indexBy('id')
           ->tableCache()
           ->column();
    }


}