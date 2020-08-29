<?php

namespace catalog\helpers;

use Yii;
use yii\base\Component;
use yii\base\UserException;
use catalog\models\Product;
use catalog\models\product\SkuModel;

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
    public static function check($product, $sku, $qty = 1)
    {
        if(!($product instanceof Product)) {
            $product = Product::findOne(['_id' => (string) $product]);
        }
        if(!$product || !$product->on_sale) {
            throw new UserException('Product not exists!');
        }
        if(!$product->hasStock()) {
            throw new UserException('Product instock');
        }
        if($sku instanceof SkuModel) {
            $sku = $sku->sku;
        }
        $skuModel = $product->getSkuModel($sku);
        if(is_null($skuModel)) {
            throw new UserException('Product instock');
        }
        if($skuModel->stock < $qty) {
            throw new UserException('Product stock invalid');
        }
        $skuModel = ($skuModel instanceof Product) ? null : $skuModel; 
        return [$product, $skuModel, $qty];
    }



}