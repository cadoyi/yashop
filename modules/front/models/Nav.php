<?php

namespace front\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * nav table
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Nav extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%front_nav}}';
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
           [['title'], 'required'],
           [['parent_id'], 'integer'],
           [['sort_order'], 'default', 'value' => function() {
               if(!$this->parent_id) { 
                   $this->parent_id = 0;
               }
               $max = static::find()
                   ->andWhere(['parent_id' => $this->parent_id])
                   ->max('sort_order');
                return $max + 1;
           }],
           [['parent_id'], 'default', 'value' => 0],
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
            'sort_order' => Yii::t('app', 'Sort order'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
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
           ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_DESC ]);
    }



    /**
     * 是否有子节点。
     * 
     * @return boolean 
     */
    public function hasChild()
    {
        return $this->getChilds()->count() > 0;
    }



    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $parent = $this->parent;
        if($parent) {
            $path = $parent->path . '/' . $this->id;
            $level = $parent->level + 1;            
        } else {
            $path = $this->id;
            $level = 1;
        }
        static::updateAll(['path' => $path, 'level' => $level], ['id' => $this->id]);
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