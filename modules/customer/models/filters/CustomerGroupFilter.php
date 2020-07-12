<?php

namespace customer\models\filters;

use Yii;
use cando\db\ActiveFilter;
use customer\models\CustomerGroup;


class CustomerGroupFilter extends ActiveFilter
{

    public $modelClass = CustomerGroup::class;


    /**
     * @inheritdoc
     */
    protected function _search($query)
    {
        return $query->andWhere([
           'and',
           ['id' => $this->id ],
           ['like', 'name', $this->name ],
        ]);
    }
}