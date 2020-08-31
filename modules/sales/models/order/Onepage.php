<?php

namespace sales\models\order;

use Yii;
use yii\base\Component;
use sales\models\OrderItem;
use sales\models\Order;
use sales\models\OrderAddress;
use sales\models\Amount;
use sales\models\OrderStatusHistory;
use catalog\models\product\SkuModel;
use catalog\helpers\Stock;

/**
 * 设置订单的保存逻辑
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Onepage extends Component
{

    public $quote;
    public $address;

    protected $_items = [];

    protected $_orders = [];

    protected $_addresses = [];

    protected $_amount;



    /**
     * 添加产品
     * 
     * @param Product $product 产品
     * @param SkuModel|null $skuMode  SkuModel
     * @param int $qty     库存
     */
    public function addProduct($product, $skuModel, $qty, $quoteItem)
    {
        $store_id = $product->store_id;
        $this->_items[$store_id][] = $item = new OrderItem([
            'quote_item_id' => (string) $quoteItem->id,
            'store_id'      => $product->store_id,
            'product_id'    => (string) $product->id,
            'product_spu'   => $product->sku,
            'product_sku'   => ($skuModel instanceof SkuModel) ? $skuModel->sku : null,
            'product_sku_info' => ($skuModel instanceof SkuModel) ? serialize($skuModel->attributes) : null,
            'product_name'     => $product->name,
            'product_price'    => $skuModel->price,
            'product_image'    => $skuModel->image ?? $product->image,
            'qty_ordered'      => $qty,
            'is_virtual'       => $product->is_virtual,
            'grand_total'      => $skuModel->getFinalPrice($qty),
        ]);
        $item->generateId();
    }



    /**
     * 处理产品.
     */
    public function process()
    {
        $quote = $this->quote;
        foreach($quote->items as $item) {
            $product = $item->product;
            list($product, $skuModel, $qty) = Stock::check($item->product_id, $item->product_sku, $item->qty);
            if($skuModel) {
                $result = $skuModel->subStock($qty);
            } else {
                $result = $product->subStock($qty);
            }
            if(!$result) {
                throw new \Exception('Product stock invalid');
            }
            $this->addProduct($product, $skuModel, $qty, $item);
        }
    }



    /**
     * 处理订单数据.
     */
    public function processOrders()
    {
        foreach($this->_items as $storeId => $storeItems) {
            $this->_orders[$storeId] = $order = new Order([
                'store_id'          => $storeId,
                'status'            => 'pending',
                'customer_id'       => Yii::$app->user->id,
                'customer_group_id' => Yii::$app->user->identity->group_id,
                'grand_total'       => 0,
                'qty_ordered'       => 0, 
            ]);
            foreach($storeItems as $item) {
                $order->grand_total += $item->grand_total;
                $order->qty_ordered += $item->qty_ordered;
            }
            $order->generateId();
            //$order->generateIncrementId();
        }
    }



    /**
     * 处理 amount
     */
    public function processAmount()
    {
        $this->_amount = new Amount([
            'customer_id' => Yii::$app->user->id,
            'customer_group_id' => Yii::$app->user->identity->group_id,
            'quote_id' => (string) $this->quote->id,
            'remote_ip' => Yii::$app->request->getUserIP(),
            'grand_total' => 0,
            'qty_ordered' => 0,
        ]);
        foreach($this->_orders as $order) {
            $this->_amount->grand_total += $order->grand_total;
            $this->_amount->qty_ordered += $order->qty_ordered;
        }
        $this->_amount->generateId();
        $this->_amount->generateIncrementId();
    }


    /**
     * 处理地址.
     * 
     * @return boolean
     */
    public function processAddress()
    {
        foreach($this->_items as $storeId => $storeItems) {
            $this->_addresses[$storeId] = $address = new OrderAddress([
                'customer_id' => $this->address->customer_id,
                'region' => $this->address->region,
                'city'   => $this->address->city,
                'area'   => $this->address->area,
                'street' => $this->address->street,
                'name'   => $this->address->name,
                'phone'  => $this->address->phone,
                'tag'    => $this->address->tag,
            ]);
        }
    }


    /**
     * 保存订单
     * 
     * @return Order
     */
    public function saveOrder()
    {
        $this->process();
        $this->processOrders();
        $this->processAddress();
        $this->processAmount();

        $result = $this->_amount->save();
        if(!$result) {
            throw new \Exception('amount save failed');
        }
        $amount_increment_id = $this->_amount->increment_id;
        foreach($this->_orders as $order) {
            $order->generateIncrementId();
            $order->amount_increment_id = $amount_increment_id;
            if(false === $order->save()) {
                throw new \Exception('order save failed');
            }
            $order->addStatusHistoryComment('待付款');
        }
        foreach($this->_addresses as $storeId => $address) {
            $order = $this->_orders[$storeId];
            $address->increment_id = $order->increment_id;
            $address->amount_increment_id = $order->amount_increment_id;
            if(false === $address->save()) {
                throw new \Exception('address save failed');
            }
        }
        foreach($this->_items as $storeId => $storeItems) {
            $order = $this->_orders[$storeId];
            foreach($storeItems as $item) {
                $item->increment_id = $order->increment_id;
                $item->amount_increment_id = $order->amount_increment_id;
                if(false === $item->save()) {
                    throw new \Exception('item save failed');
                }
            }
        }
        foreach($this->_orders as $order) {
            $order->syncToStore();
        }
        return $this->_amount;
    }

}