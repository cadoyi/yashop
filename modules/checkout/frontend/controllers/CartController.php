<?php

namespace checkout\frontend\controllers;

use Yii;
use yii\base\UserException;
use frontend\controllers\Controller;
use catalog\models\Product;
use customer\models\Customer;
use checkout\models\filters\CartItemFilter;
use checkout\models\CartItem;


/**
 * add to cart
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CartController extends Controller
{


    /**
     * 获取 cusotmer 模型
     * 
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->identity;
    }


    /**
     * 列出购物车中的所有条目
     * 
     * @return string
     */
    public function actionIndex()
    {
        $customer = $this->getCustomer();
        $cart = $customer->getCart();
        $filterModel = new CartItemFilter(['cart' => $cart]);
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('index', [
            'customer'     => $customer,
            'cart'         => $cart,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 添加到购物车
     * 
     * @return string
     */
    public function actionAdd($product_id)
    {
        $product = $this->findModel($product_id, Product::class);

        try {        
            if(!$product->isOnSale()) {
                throw new \Exception('产品无法售卖');
            }
            if($product->is_selectable) {
                $product_sku_id = $this->request->post('product_sku');
                $sku = $product->getSku($product_sku_id);
                if(!$sku) {
                    throw new \Excetpion('Invalid product sku');
                }
            } else {
                $sku = null;
            }
            $qty = $this->request->post('qty', 1);
            $data = [];
            $cart = $this->getCustomer()->getCart();
            $cart->addItem($product, $sku, $qty);
            $data['success'] = true;
        } catch(UserException $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        } catch(\Exception $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        } catch(\Throwable $e) {
            $data['success'] = false;
            $data['message'] = 'Server error';
        }
        if($this->request->isAjax) {
            return $this->asJson($data);
        }
        if($data['success'] === false) {
            $this->_error($data['message']);
            return $this->redirect(['/catalog/product/view', 'id' => $product_id]);
        }
        return $this->redirect(['index']);
        
    }







    /**
     * 移除购物车中的一条
     * 
     * @param  int $id   
     * @return string
     */
    public function actionRemoveItem( $id )
    {
         $item = $this->findModel($id, CartItem::class);
         $cart = $this->getCustomer()->getCart();
         if($item->cart_id !== $cart->id) {
              return $this->notFound();
         }
         $item->delete();
         $this->_success('Item is removed');
         return $this->redirect(['index']);
    }



    /**
     * 清空购物车
     * 
     * @return string
     */
    public function actionEmpty()
    {
        $cart = $this->getCustomer()->getCart();
        $cart->removeAllItems();
        $this->_success('Shopping cart is empty');
        return $this->redirect(['index']);
    }



    /**
     * 更新购物车项目的 qty 
     * 
     * @param  int $id   购物车项目的 ID 值
     * @return string
     */
    public function actionUpdateItemQty( $id )
    {
        $qty = $this->request->post('qty');
        if(!$qty || !is_numeric($qty) || $qty < 1 ) {
            $data['message'] = Yii::t('app', 'Invalid qty number');
            return $this->asJson($data);
        }
        $qty = (int) $qty;
        $data = ['success' => false];
        $item = $this->findModel($id, CartItem::class, false);
        if(!$item) {
            $data['message'] = Yii::t('app', 'Item not found');
            return $this->asJson($data);
        }
        $product = $item->product;
        if($product->is_selectable) {
            $productSku = $item->productSku;
            if(!$productSku) {
                $data['message'] = Yii::t('app', 'Product sku invalid');
                return $this->asJson($data);
            }
            $stock = $productSku->qty;
        } else {
            $stock = $product->inventory->qty;
        }
        $model = $product->is_selectable ? $productSku : $product;
        if($stock < $qty) {
            $data['message'] = Yii::t('app', 'Inventory is beyond');
            return $this->asJson($data);                    
        }
        $item->qty = $qty;
        $item->save();
        $data = [
            'success' => true,
            'data' => [
                'qty'   => $item->qty,
                'price' => $model->getFinalPrice($item->qty),
            ],
        ];
        return $this->asJson($data);
    }
}