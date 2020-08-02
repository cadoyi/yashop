<?php

namespace cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;


/**
 * cms article
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Article extends ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_article}}';
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
     * 
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['title', 'content', 'author', 'category_id'], 'required'],
           [['title', 'author'], 'string', 'max' => 255],
           [['content', 'meta_keywords', 'meta_description'], 'string'],
           [['category_id'], 'integer'],
           [['category_id'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title'      => Yii::t('app', 'Article title'),
            'content'    => Yii::t('app', 'Article content'),
            'category_id' => Yii::t('app', 'Article category'),
            'author'      => Yii::t('app', 'Article author'),
            'meta_keywords' => Yii::t('app', 'Meta keywords'),
            'meta_description' => Yii::t('app', 'Meta description'),
            'created_at'  => Yii::t('app', 'Created at'),
            'updated_at'  => Yii::t('app', 'Updated at'),
        ];
    }



    /**
     * 获取 tags
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, [
            'id' => 'tag_id'
        ])->via('articleTags');
    }




    /**
     * 获取文章标签关联表.
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::class, [
            'article_id' => 'id',
        ]);
    }


}