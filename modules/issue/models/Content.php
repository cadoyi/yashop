<?php

namespace issue\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * issue content
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Content extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%issue_content}}';
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
            [['title', 'content'], 'required'],
            [['category_id', 'menu_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['content'], 'string'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title'      => Yii::t('app', 'Title'),
            'content'    => Yii::t('app', 'Content'),
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
     * 获取分类。
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }



    /**
     * 设置 menu
     *
     * @param  Menu $menu 
     */
    public function setMenu(Menu $menu)
    {
        $this->category_id = $menu->category_id;
        $this->menu_id = $menu->id;
        $this->populateRelation('menu', $menu);
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


}