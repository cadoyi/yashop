<?php

namespace customer\models\filters;

use Yii;
use cando\db\ActiveFilter;
use customer\models\CustomerOauth;


/**
 * 过滤 customer oauth 账户
 * 
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerOauthFilter extends ActiveFilter
{

    public $modelClass = CustomerOauth::class;


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