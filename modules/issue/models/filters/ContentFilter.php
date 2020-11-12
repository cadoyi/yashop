<?php

namespace issue\models\filters;

use Yii;
use cando\db\ActiveFilter;
use issue\models\Content;

/**
 * 问题内容过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ContentFilter extends ActiveFilter
{

    public $modelClass = Content::class;

    public $menu;


    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()
            ->andWhere(['category_id' => $this->menu->category_id])
            ->andWhere(['menu_id' => $this->menu->id]);
    }



    /**
     * @inheritdoc
     */
    protected function _search( $query ) 
    {
        return $query->andFilterWhere(['like', 'title', $this->title]);
    }

}