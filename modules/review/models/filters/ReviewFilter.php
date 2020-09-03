<?php

namespace review\models\filters;

use Yii;
use cando\mongodb\ActiveFilter;
use review\models\Review;

/**
 * 评价过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ReviewFilter extends ActiveFilter
{

    public $modelClass = Review::class;



    /**
     * @inheritdoc
     */
    public function load( $data, $formName = null)
    {
        $product_id  = $this->product_id;
        $customer_id = $this->customer_id;
        $order_id    = $this->order_id;
        $result      = parent::load($data, $formName);
        if($product_id) {
            $this->product_id = $product_id;
        }
        if($customer_id) {
            $this->customer_id = $customer_id;
        }
        if($order_id) {
            $this->order_id = $order_id;
        }
        return $result;
    }



    /**
     * 配置数据提供器.
     * 
     * @param  yii\db\ActiveQuery $query
     * @return array
     */
    public function dataProviderConfig( $query )
    {
        return [
           'pagination' => [
               'pageSize' => 1,
           ],
        ];
    }



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
            'and',
            ['customer_id' => (string) $this->customer_id],
            ['product_id'  => (string)  $this->product_id],
            ['order_id'    => (string) $this->order_id],
            ['score'       => (string) $this->score],
        ]);
    }






}