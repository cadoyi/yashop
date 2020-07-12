<?php

namespace customer\models\filters;

use Yii;
use cando\db\ActiveFilter;
use customer\models\CustomerAccount;

/**
 * 用户账户过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerAccountFilter extends ActiveFilter
{

    public $modelClass = CustomerAccount::class;

    public $customer;


    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()->andWhere(['customer_id' => $this->customer->id ]);
    }

    

    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {

    }

}