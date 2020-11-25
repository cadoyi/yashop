<?php

namespace wishlist\models\filters;

use Yii;
use cando\db\ActiveFilter;
use wishlist\models\WishlistProduct;


/**
 * wishlist item filter
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class WishlistProductFilter extends ActiveFilter
{

    public $modelClass = WishlistProduct::class;


    public $wishlist;


    /**
     * @inheritdoc
     */
    public function query()
    {
        return $this->wishlist->getProducts()->with('product');
    }



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {

    }



}