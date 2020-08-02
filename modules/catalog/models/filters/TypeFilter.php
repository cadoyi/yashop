<?php

namespace catalog\models\filters;

use Yii;
use cando\db\ActiveFilter;
use catalog\models\Type;

/**
 * 类型过滤器.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TypeFilter extends ActiveFilter
{

    public $modelClass = Type::class;



    /**
     * @inheritdoc
     */
    protected function _search( $query ) 
    {
        $query->andFilterWhere([
            'and',
            [ 'id' => $this->id ],
            [ 'like', 'name', $this->name ],
            [ 'category_id' => $this->category_id ],
        ]);
    }

}