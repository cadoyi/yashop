<?php

namespace customer\models\filters;

use Yii;
use cando\db\ActiveFilter;
use customer\models\CustomerAddress;

/**
 * 地址过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerAddressFilter extends ActiveFilter
{

    public $modelClass = CustomerAddress::class;

    public $customer;


    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()->andWhere(['customer_id' => $this->customer->id]);
    }




    /**
     * @inheritdoc
     */
    protected function _search($query)
    {
        
    }

}