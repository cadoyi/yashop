<?php

namespace catalog\models\filters;

use Yii;
use cando\mongodb\ActiveFilter;
use catalog\models\Brand;



/**
 * 品牌过滤器.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class BrandFilter extends ActiveFilter
{

    public $modelClass = Brand::class;




    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
            ['like', 'name', $this->name],
        ]);
    }


}
