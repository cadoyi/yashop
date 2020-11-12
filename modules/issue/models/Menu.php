<?php

namespace issue\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 问题分类子菜单
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
        return '{{%issue_menu}}';
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
           [['title', 'category_id'], 'required'],
           [['title'], 'string', 'max' => 255],
           [['category_id', 'parent_id'], 'integer'],
           [['path'], 'string'],
           [['level'], 'integer'],
           [['sort_order'], 'default', 'value' => function() {
               if(!$this->parent_id) { 
                   $this->parent_id = 0;
               }
               $max = static::find()
                   ->andWhere(['parent_id' => $this->parent_id])
                   ->max('sort_order');
                return $max + 1;
           }],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code'       => Yii::t('app', 'Unique code'),
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
     * 设置分类
     * 
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category_id = $category->id;
        $this->populateRelation('category', $category);
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


}