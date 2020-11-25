<?php

namespace shop\models\filters;

use Yii;
use cando\db\ActiveFilter;
use catalog\models\Product;


/**
 * 产品 filter
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductFilter extends ActiveFilter
{


    public $modelClass = Product::class;




    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()
            ->andWhere(['store_id' => Yii::$app->currentStore->id]);
    }



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
         $query->andFilterWhere([
             'and',
             ['like', 'title', $this->title],

         ]);
    } 

}