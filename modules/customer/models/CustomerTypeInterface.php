<?php

namespace customer\models;

use Yii;

/**
 * 账户类型
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
interface CustomerTypeInterface
{


    /**
     * 获取 customer
     * 
     * @return Customer
     */
    public function getCustomer();



    /**
     * 获取 identity
     * 
     * @return Customer
     */
    public function getIdentity();



}