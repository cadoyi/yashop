<?php

namespace checkout\models\filters;

use Yii;
use cando\db\ActiveFilter;
use checkout\models\CartItem;


/**
 * 过滤 cart item
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CartItemFilter extends ActiveFilter
{

    public $modelClass = CartItem::class;
    

    public $cart;


    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()->andWhere(['cart_id' => $this->cart->id]);
    }


    




}