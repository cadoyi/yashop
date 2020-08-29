<?php

namespace checkout\frontend\controllers;

use Yii;
use yii\base\UserException;
use frontend\controllers\Controller;
use catalog\models\Product;
use checkout\models\Quote;
use checkout\models\Cart;
use checkout\helpers\QuoteHelper;


/**
 * 一个步骤完成付款
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class QuoteController extends Controller
{

    protected $_quote;


    /**
     * @inheritdoc
     */
    public function access()
    {
        return [
            'rules' => [
                [
                    'roles' => ['?'],
                    'allow' => false,
                ],
                [

                ],
            ],
        ];
    }


    /**
     * 付款确定页面
     * 
     * @return string
     */
    public function actionIndex()
    {
        $customer = $this->identity;
        $quote = $this->getQuote();
        if(is_null($quote)) {
            return $this->goBack();
        }
        $quote->collectTotals();
        $quote->save();
        return $this->render('index', ['quote' => $quote]);
    }



    
    /**
     * 将多个购物车条目添加到结算页.
     * 
     * @return string
     */
    public function actionAdd()
    {
        $itemIds = $this->request->post('carts');
        $customer = $this->identity;
        $quote = QuoteHelper::createQuote($customer);
        $cart = $customer->getCart();
        $_items = $cart->items;
        try {
            $items = [];
            foreach($itemIds as $itemId) {
                if(!isset($_items[$itemId])) {
                    throw new \Exception('Some item not exist');
                }
                $item = $_items[$itemId];
                $items[$item->id] = $item;
            }
            foreach($items as $item) {
                $quote->addItem($item);
            }
            $quote->collectTotals();
            $quote->save();
            $this->session->set('quote_id', (string) $quote->id);
        } catch(UserException $e) {
            $this->_error($e->getMessage());
            return $this->redirect(['/checkout/cart/index']);
        }
        return $this->redirect(['index']);

    }



    /**
     * 将一个产品增加到结算页
     * 
     * @return string
     */
    public function actionAddProduct($product_id)
    {
        $product = $this->findModel($product_id, Product::class, true, '_id');
        $productSku = $this->request->post('product_sku');
        $qty = $this->request->post('qty');
        $customer = $this->identity;
        $quote = QuoteHelper::createQuote($customer);
        try {
            $quote->addProduct($product, $productSku, $qty);
            $quote->collectTotals();
            $quote->save();
            $this->session->set('quote_id', (string) $quote->id);
        } catch(UserException $e) {
            $this->_error($e->getMessage());
            return $this->redirect(['/checkout/cart/index']);
        }
        return $this->redirect(['index']);
    }



    /**
     * 获取 quote
     * 
     * @return Quote
     */
    public function getQuote()
    {
        $quote_id = $this->session->get('quote_id');
        $customer = $this->identity;
        $quote = Quote::findOne($quote_id);
        if(is_null($quote)) {
            return null;
        }
        $quote->remote_ip = $this->request->getUserIP();
        if($quote->customer_id != $customer->id) {
            return null;
        }
        $quote->setCustomer($customer);
        $quote->save();        
        return $quote;
    }



}