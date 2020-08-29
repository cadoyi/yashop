<?php

namespace catalog\models\product;

use Yii;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

/**
 * sku 收集器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class SkuModel extends DynamicModel
{
    
    protected $_product;

    /**
     * @inheritdoc
     */
    public function __construct($product, $sku, $options = [])
    {
         $this->_product = $product;
         parent::__construct($sku, $options);
    }

    

    /**
     * price
     * 
     * @return number
     */
    public function getPrice()
    {
        if(empty($this->price)) {
            $this->price = $this->_product->price;
        }
        return $this->price;
    }



    /**
     * final price
     * 
     * @return number
     */
    public function getFinalPrice( $qty = 1)
    {
        $finalPrice = $this->_product->getFinalPrice();
        $finalPrice = min($this->getPrice(), $finalPrice);
        return $finalPrice * $qty;
    }




    /**
     * 是否有货
     * 
     * @return boolean 
     */
    public function hasStock()
    {
        return $this->stock > 0;
    }




    /**
     * 获取 data
     * 
     * @return array
     */
    public function getData()
    {
        $data = $this->attributes;
        $data['price'] = $this->getPrice();
        $data['finalPrice'] = $this->getFinalPrice();
        $data['imageUrl'] = $this->getImageUrl(400);
        return $data;
    }



    /**
     * 获取图片 URL
     * 
     * @param   int $width  宽度
     * @return  string
     */
    public function getImageUrl($width = null, $height = null)
    {
        if($this->image) {
            return (string) Yii::$app->storage->getUrl($this->image, $width, $height);
        }
        return $this->_product->getImageUrl($width, $height);
    }


}