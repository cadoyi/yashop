<?php

namespace sales\models\filters;

use Yii;
use cando\db\ActiveFilter;
use sales\models\Order;

/**
 * 订单过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderFilter extends ActiveFilter
{

    public $modelClass = Order::class;


    public $status;


    public $customer;


    /**
     * 查询
     */
    public function query()
    {
        $query = parent::query();
        if(!is_null($this->status)) {
            $query->andWhere(['status' => $this->status]);
        }
        if(!is_null($this->customer)) {
            $query->andWhere(['customer_id' => $this->customer->id]);
        }
        return $query;
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
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
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
            ['status' => $this->status],
        ]);
    }
}