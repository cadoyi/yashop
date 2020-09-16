<?php

namespace sales\models\order;

use Yii;
use yii\base\UserException;
use yii\base\Model;
use customer\models\CustomerAddress;
use sales\models\Order;
use sales\models\OrderItem;
use sales\models\OrderAddress;
use sales\models\OrderPaid;

use catalog\helpers\Stock;
use payment\helpers\MethodHelper;

/**
 * 设置订单的保存逻辑
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Submitter extends Model
{

    /**
     * @var  checkout\models\Quote  账单
     */
    public $quote;


    /**
     * @var customer\models\Customer
     */
    public $customer;


    /**
     * @var customer\models\CustomerAddress
     */
    public $address;


    /**
     * @var string 支付方法
     */
    public $method;


    /**
     * @var string 地址 ID
     */
    public $address_id;


    /**
     * @var string 订单序列
     */
    public $incrementPrefix;



    protected $_orderPaid;


    protected $_orders;


    protected $_items;


    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->incrementPrefix = date('ymdHis');
        $this->quote = $this->customer->getQuote();
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['method'], 'required'],
            [['method'], 'string'],
            [['method'], 'in', 'range' => array_keys(MethodHelper::getPaymentMethods())],
            [['address_id'], 'required', 'when' => function($model, $attribute) {
                return !$this->quote->is_virtual;
            }],
            [['address_id'], 'integer'],
            [['address_id'], 'validateAddress'],
        ];
    }



    /**
     * 验证地址.
     */
    public function validateAddress($attribute)
    {
        $address = CustomerAddress::findOne([
            'customer_id' => $this->customer->id,
            'id'          => $this->$attribute,
        ]);
        if(!$address) {
            $this->addError($attribute, 'address_id invalid');
            return;
        }
        $address->setCustomer($this->customer);
        $this->address = $address;
    }




    /**
     * 获取支付单.
     * 
     * @return array
     */
    public function getOrderPaid()
    {
        if(!$this->_orderPaid) {
            $this->_orderPaid = new OrderPaid([
                'customer'    => $this->customer,
                'status'      => OrderPaid::STATUS_PENDING,
                'method'      => $this->method,
                'grand_total' => 0,
                'qty_ordered' => 0,
                'is_virtual'  => $this->quote->is_virtual,
            ]);
            $this->_orderPaid->generateIncrementId($this->incrementPrefix);
        }
        return $this->_orderPaid;
    }



    /**
     * 获取 order_item 列表
     * 
     * @return array
     */
    public function getOrderItems()
    {
        if(is_null($this->_items)) {
            $quote = $this->quote;
            $items = $quote->items;

            $this->_items = [];
            foreach($items as $item) {
                $product    = $item->product;
                $productSku = $item->productSku;
                $qty        = $item->qty;
                if(!$product->isOnSale()) {
                    throw new UserException("产品: \"{$product->name}\" 不能售卖!");
                }
                if(!Stock::check($product, $productSku, $qty)) {
                    throw new UserException("产品: \"{$product->name}\" 库存不足!");
                }
                $store_id = $product->store_id;
                $_item = new OrderItem();
                $_item->setProduct($product, $productSku, $qty);
                Stock::decr($product, $productSku, $qty);
                $this->_items[$store_id][] = $_item;
            }        
        }
        return $this->_items;  
    }


    
    /**
     * 获取 orders
     * 
     * @return array
     */
    public function getOrders()
    {
        if(is_null($this->_orders)) {
            $this->_orders = [];
            $idx = 1;
            foreach($this->getOrderItems() as $storeId => $storeItems) {
                 $order = new Order([
                    'store_id'    => $storeId,
                    'customer'    => $this->customer,
                    'status'      => Order::STATUS_PENDING,
                    'grand_total' => 0,
                    'qty_ordered' => 0,
                    'is_virtual'  => 1,
                ]);
                $order->generateIncrementId($this->incrementPrefix, $idx++);

                // 计算 grand_total 和 qty_ordered
                foreach($storeItems as $storeItem) {
                    $order->grand_total += $storeItem->row_total;
                    $order->qty_ordered += $storeItem->qty_ordered;

                    if(!$storeItem->is_virtual) {
                        $order->is_virtual = 0;
                    }
                    $storeItem->setOrder($order);
                }
                $this->_orders[$storeId] = $order;
            }            
        }
        return $this->_orders;
    }


    /**
     * 处理订单逻辑.
     */
    public function process()
    {
        $orderPaid = $this->getOrderPaid();
        $orders = $this->getOrders();

        // 计算总价
        foreach($orders as $storeId => $order) {
            $orderPaid->grand_total += $order->grand_total;
            $orderPaid->qty_ordered += $order->qty_ordered;
        }

        //保存计费单
        $orderPaid->save();


        //保存分单
        foreach($orders as $storeId => $order) {
            $order->setOrderPaid($orderPaid);
            $order->save();
        }


        // 保存分单 items
        foreach($this->getOrderItems() as $storeId => $orderItems) {
            $order = $orders[$storeId];
            foreach($orderItems as $item) {
                $item->setOrder($order);
                $item->save();
            }
        }

        // 保存地址
        foreach($orders as $storeId => $order) {
            if(!$order->is_virtual) {
                $address = new OrderAddress([
                     'order'   => $order,
                     'address' => $this->address,
                ]);
                $address->save();
            }
        }


        // 删除 quote
        $this->quote->truncate();
        $this->quote->save();
    }


    



    /**
     * 保存订单
     * 
     * @return Order
     */
    public function saveOrder()
    {
        $trans = Order::getDb()->beginTransaction();
        try {
            $this->process();
            $trans->commit();
        } catch(\Throwable $e) {
            $trans->rollBack();
            throw $e;
        }
        return $this->getOrderPaid();
    }

}