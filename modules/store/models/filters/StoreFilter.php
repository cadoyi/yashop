<?php

namespace store\models\filters;

use Yii;
use cando\db\ActiveFilter;
use store\models\Store;

/**
 * store 过滤器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class StoreFilter extends ActiveFilter
{

    public $modelClass = Store::class;


    /**
     * @inheritdoc
     */
    protected function _search( $query ) 
    {
        $query->andFilterWhere([
            'and',
            ['id' => $this->id],
            ['like', 'name', $this->name],
            ['type' => $this->type],
            ['like', 'phone', $this->phone],
            ['status' => $this->status],
            ['is_platform' => $this->is_platform],
            ['like', 'legal_person', $this->legal_person],
            ['like', 'company_name', $this->company_name],
        ]);
    }

}