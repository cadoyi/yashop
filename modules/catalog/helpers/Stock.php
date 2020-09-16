<?php

namespace catalog\helpers;

use Yii;
use yii\base\Component;
use yii\base\UserException;
use catalog\models\Product;
use catalog\models\ProductSku;

/**
 * 库存组件
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Stock extends Component
{


    /**
     * 检查产品和库存
     * 
     * @param  string|Product $product 产品
     * @param  string $sku    产品 SKU
     * @param  int    $qty    库存数
     * @return boolean
     */
    public static function check(Product $product, $productSku, $qty = 1)
    {
        if(isset($productSku)) {
            return $productSku->qty >= $qty;
        }
        return $product->qty >= $qty;
    }



    /**
     * 扣除库存
     * 
     * @param  Product $product        产品
     * @param  ProductSku  $productSku 产品 SKU
     * @param  int  $qty               扣除数量
     */
    public static function decr(Product $product, $productSku, $qty)
    {
        if(isset($productSku)) {
             $result = $productSku->decrQty($qty);
        } else {
             $result = $product->decrQty($qty);
        }
        if(!$result) {
            throw new UserException('产品库存不足!');
        }
        return $result;
    }



}