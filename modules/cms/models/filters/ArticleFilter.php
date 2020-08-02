<?php

namespace cms\models\filters;

use Yii;
use cando\db\ActiveFilter;
use cms\models\Article;

/**
 * 文章过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ArticleFilter extends ActiveFilter
{

    public $modelClass = Article::class;




    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
            'and',
            ['like', 'title', $this->title],
            ['like', 'author', $this->author],
            ['category_id' => $this->category_id],
        ]);
    }

}