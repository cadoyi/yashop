<?php

namespace cms\models\filters;

use Yii;
use cando\db\ActiveFilter;
use cms\models\Tag;

/**
 * 标签过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TagFilter extends ActiveFilter
{

    public $modelClass = Tag::class;



    /**
     * @inheritdoc
     */
    protected function _search($query)
    {
        $query->andFilterWhere(['like', 'name', $this->name]);
    }

}