<?php

namespace wishlist\models\filters;

use Yii;
use cando\db\ActiveFilter;
use wishlist\models\WishlistItem;


/**
 * wishlist item filter
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class WishlistItemFilter extends ActiveFilter
{

    public $modelClass = WishlistItem::class;


    public $wishlist;


    /**
     * @inheritdoc
     */
    public function query()
    {
        return $this->wishlist->getItems()->with('product');
    }



    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {

    }



}