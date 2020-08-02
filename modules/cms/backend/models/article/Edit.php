<?php

namespace cms\backend\models\article;

use Yii;
use yii\helpers\ArrayHelper;
use cms\models\Article;
use cms\models\ArticleTag;
use cms\models\Tag;


/**
 * 编辑文章.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Edit extends Article
{

    public $tagIds = [];



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
             [['tagIds'], 'each', 'rule' => [
                 'integer',
             ]],
             [['tagIds'], 'each', 'rule' => [
                 'exist',
                 'targetClass' => Tag::class,
                 'targetAttribute' => 'id',
             ]],
        ]);
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'tagIds' => '标签',
        ]);
    }


    
    /**
     * 保存.
     * 
     * @param  boolean $runValidation  [description]
     * @param  [type]  $attributeNames [description]
     * @return [type]                  [description]
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $trans = static::getDb()->beginTransaction();
        try {
            $result = parent::save($runValidation, $attributeNames);
            if($result === false) {
                throw new \Exception('Article save failed');
            }
            $this->saveTags();
            $trans->commit();
            return true;
        } catch( \Exception $e) {
            $trans->rollBack();
            throw $e;
        } catch( \Throwable $e) {
            $trans->rollBack();
            throw $e;
        }
        return $result;
    }



    /**
     * 获取 tagId values
     * 
     * @return array
     */
    public function getTagIdsValue()
    {
        return  array_keys(ArrayHelper::index($this->articleTags, 'tag_id'));
    }



    /**
     * 保存标签.
     */
    public function saveTags()
    {
        $tagIds = $this->tagIds;
        $olds = ArrayHelper::index($this->articleTags, 'tag_id');
        $_tagIds = array_keys($olds);

        $_deletes = array_diff($_tagIds, $tagIds);
        $_inserts = array_diff($tagIds, $_tagIds);
        foreach($_deletes as $deleteTagId) {
            $tag = $olds[$deleteTagId];
            $tag->delete();
        }
        foreach($_inserts as $insertTagId) {
            $tag = new ArticleTag([
                'article_id' => $this->id,
                'tag_id' => $insertTagId,
            ]);
            $tag->save();
        }


    }


}