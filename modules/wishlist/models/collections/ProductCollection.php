<?php

namespace wishlist\models\collections;

use Yii;
use yii\base\Component;
use catalog\models\Product;
use wishlist\models\WishlistProduct;

/**
 * 产品收集器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductCollection extends Component
{

    public $wishlist;


    /**
     * 添加产品
     * 
     * @param Product $product 
     */
    public function addProduct(Product $product)
    {
        $wishlist = $this->wishlist;
        $products = $wishlist->products;
        if(isset($products[$product->id])) {
            return $products[$product->id];
        }
        $item = new WishlistProduct([
            'wishlist' => $this->wishlist,
            'product'  => $product,
        ]);
        $item->save();
        $products[$product->id] = $item;
        $wishlist->populateRelation('products', $products);
        return $item;
    }



    /**
     * 移除产品
     * 
     * @param  Product $product
     * @return boolean
     */
    public function removeProduct(Product $product)
    {
        $wishlist = $this->wishlist;
        $products = $wishlist->products;
        if(isset($products[$product->id])) {
            $item = $products[$product->id];
            return $this->remove($item);
        }
        return true;
    }


    /**
     * 根据 item_id 来移除 item
     * 
     * @param  int|ProduuctItem  $item
     * @return boolean
     */
    public function removeItem( $item )
    {
        if($item instanceof WishlistProduct) {
            return $this->remove($item);
        }
        $wishlist = $this->wishlist;
        $products = $wishlist->products;
        foreach($products as $productItem) {
            if($productItem->id === (int) $item) {
                return $this->remove($productItem);
            }
        }
        return true;
    }



    /**
     * 移除 item
     * 
     * @param  WishlistProduct $item 
     * @return boolean
     */
    public function remove( WishlistProduct $item ) 
    {
        $wishlist = $this->wishlist;
        $products = $wishlist->products;
        $productId = $item->product_id;
        $item->delete();
        unset($products[$productId]);
        $wishlist->populateRelation('products', $products);
        return true;
    }


}