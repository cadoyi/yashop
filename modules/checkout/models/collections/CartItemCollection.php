<?php

namespace checkout\models\collections;

use Yii;
use yii\base\Component;
use checkout\models\CartItem as Item;

/**
 * cart item collection
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CartItemCollection extends Component
{

    public $cart;


    /**
     * 增加产品
     * 
     * @param Product $product 
     * @param ProductSku $productSku 
     * @param int $qty        
     */
    public function addProduct($product, $productSku, $qty = 1)
    {
        $item = new Item([
            'product' => $product,
            'productSku' => $productSku,
            'qty' => $qty,
            'cart' => $this->cart,
        ]);
        return $this->add($item);
    }


    /**
     * 增加 item
     * 
     * @param Item $item  必须是新实例。
     */
    public function add(Item $item)
    {
        $cart = $this->cart;
        foreach($cart->items as $_item) {
            if($this->eq($item, $_item)) {
                $_item->qty += $item->qty;
                $_item->save();
                return $_item;
            }
        }
        $item->cart = $cart;
        $item->save();
        $items = $cart->items;
        $items[$item->id] = $item;
        $cart->populateRelation('items', $items);
        return $item;
    }



    /**
     * 比较两个 item 是否为 1 个
     * 
     * @param  Item $item1 
     * @param  Item $item2 
     * @return boolean
     */
    protected function eq($item1, $item2)
    {
        return $item1->product_id === $item2->product_id &&
               $item1->product_sku_id == $item2->product_sku_id;
    }



    /**
     * 移除某个 item
     * 
     * @param  Item|int  $item 
     */
    public function remove($item)
    {
        $cart = $this->cart;
        if($item instanceof Item) {
            $id = $item->id;
        } else {
            $id = $item;
        }
        if($cart->isRelationPopulated('items')) {
            $items = $cart->items;
            $item = $items[$id] ?? $item;
            unset($items[$id]);
            $cart->populateRelation($items);
            if($item instanceof Item) {
                return $item->delete();
            }
            return true;
        } else {
            if(!($item instanceof Item)) {
                if(!$item = Item::findOne($id)) {
                    return true;
                }
            }
            return $item->delete();
        }
    }


    
    /**
     * 清空所有 items
     */
    public function clear()
    {
        $cart = $this->cart;
        foreach($cart->items as $item) {
            $item->delete();
        }
        $cart->populateRelation('items', []);
    }



    /**
     * 计算总数。
     * 
     * @return int
     */
    public function getCount()
    {
        $cart = $this->cart;
        if($cart->isRelationPopulated('items')) {
            return count($cart->items);
        }
        return $cart->getItems()->count();
    }



}