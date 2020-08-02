<?php

namespace catalog\models\filters;

use Yii;
use cando\db\ActiveFilter;
use catalog\models\TypeAttribute;


/**
 * 产品类型属性过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TypeAttributeFilter extends ActiveFilter
{

    public $modelClass = TypeAttribute::class;


    public $type;


    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()->andWhere(['type_id' => $this->type->id ]);
    }



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
            'and',
            ['id' => $this->id],
            ['like', 'name', $this->name],
            ['input_type' => $this->input_type],
            ['is_active'  => $this->is_active],
        ]);
    }

}