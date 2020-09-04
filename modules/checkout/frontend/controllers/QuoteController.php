<?php

namespace checkout\frontend\controllers;

use Yii;
use yii\base\UserException;
use frontend\controllers\Controller;
use catalog\models\Product;
use catalog\models\ProductSku;
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
        $quote = $customer->getQuote();
        if(is_null($quote) || empty($quote->items)) {
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
        $cart = $customer->getCart();
        $_items = $cart->items;
        $trans = Quote::getDb()->beginTransaction();
        try {
            $quote = $customer->getQuote();
            $quote->truncate();
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
                $item->delete();
            }
            $quote->collectTotals();
            $quote->save();
            $trans->commit();
        } catch(UserException $e) {
            $trans->rollBack();
            $this->_error($e->getMessage());
            return $this->redirect(['/checkout/cart/index']);
        } catch(\Throwable $e) {
            $trans->rollBack();
            throw $e;
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
        $qty = $this->request->post('qty', 1);
        $product = $this->findModel($product_id, Product::class, false);
        $productSku = null;
        if($product->is_selectable) {
            $productSkuId = $this->request->post('product_sku');
            if(!$productSkuId) {
                $this->_error('Invalid request');
                return $this->goBack();
            }
            $productSku = $this->findModel($productSkuId, ProductSku::class, false);
            if(!$productSku) {
                $this->_error('不可用的产品选项');
                return $this->goBack();
            }
        }
        $customer = $this->identity;
        $trans = Quote::getDb()->beginTransaction();
        try {
            $quote = $customer->getQuote();
            $quote->truncate();
            $quote->addProduct($product, $productSku, $qty);
            $quote->collectTotals();
            $quote->save();
            $trans->commit();
        } catch(UserException $e) {
            $trans->rollBack();
            $this->_error($e->getMessage());
            return $this->goBack();
        } catch(\Throwable $e) {
            $trans->rollBack();
            throw $e;
        }
        return $this->redirect(['index']);
    }



}