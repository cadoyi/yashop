<?php

namespace catalog\models\product;

use Yii;
use yii\base\Component;

/**
 * 产品价格模型
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class PriceModel extends Component
{

    public $product;



    /**
     * 获取优惠价格
     * 
     * @return number
     */
    public function getPromotePrice()
    {
        $promotePrice = $this->product->promote_price;
        $start = $this->product->promote_start_date;
        $end   = $this->product->promote_end_date;
        $time = time();
        $start = empty($start) ? $time : strtotime($start);
        $end = empty($end) ? ($time + 60) : strtotime($end); 
        if($time >= $start && $time <= $end && !empty($promotePrice)) {
            return $promotePrice;
        }
        return false;
    }




    /**
     * 获取产品的最终价格
     * 
     * @return number
     */
    public function getFinalPrice( $qty = 1 )
    {
        $price = $this->product->price;
        $promotePrice = $this->getPromotePrice();
        if(false === $promotePrice) {
            return $price;
        }
        $finalPrice = min($price, $promotePrice);
        return $finalPrice * $qty;
    }

}