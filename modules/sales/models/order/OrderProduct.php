<?php

namespace sales\models\order;

use Yii;
use yii\base\BaseObject;

/**
 * 产品
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OrderProduct extends BaseObject
{

    public $orderItem;


    /**
     * @inheritdoc
     */
    public function __construct($orderItem, $config = [])
    {
        $this->orderItem = $orderItem;
        parent::__construct($config);
    }



    /**
     * 获取产品名
     * 
     * @return string
     */
    public function getName()
    {
        return $this->orderItem->name;
    }



    /**
     * 获取图片
     */
    public function getImage()
    {
        $image = $this->orderItem->product_sku_image;
        if(!$image) {
            $image = $this->orderItem->image;
        }
        return $image;
    }



    /**
     * 获取图片 URL
     *
     * @param  int $width 图片宽度
     * @param  int $height 图片高度
     * @return string
     */
    public function getImageUrl($width = null, $height = null)
    {
        $image = $this->image;
        return Yii::$app->storage->getUrl($image, $width, $height);
    }



    /**
     * 获取价格.
     * 
     * @return numeric
     */
    public function getPrice()
    {
        if(!($price = $this->orderItem->product_sku_price)) {
            $price = $this->orderItem->price;
        }
        return $price;
    }



    /**
     * 获取总价
     * 
     * @return numeric
     */
    public function getRowTotal()
    {
        return $this->orderItem->row_total;
    }


    /**
     * 获取产品数量.
     * 
     * @return int
     */
    public function getQty()
    {
        return $this->orderItem->qty_ordered;
    }

    /**
     * 获取产品属性列表
     * 
     * @return array
     */
    public function getAttrs()
    {
        $attrs = $this->orderItem->product_sku_attrs;
        if(empty($attrs)) {
            $attrs = [];
        }
        return $attrs;
    }

}