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
class ArticleTag extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_article_tag}}';
    }




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'required'],
            [['article_id', 'tag_id'], 'integer'],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => Yii::t('app', 'Article'),
            'tag_id'     => Yii::t('app', 'Article tag'),
        ];
    }


}