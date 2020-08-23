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
    public $enableCsrfValidation = false;


    /**
     * 获取 cusotmer 模型
     * 
     * @return Customer
     */
    public function getCustomer()
    {
        if($this->user->isGuest) {
            return Customer::findOne(['id' => 5]);
        }
        return $this->identity;
    }


    /**
     * 添加到购物车
     * 
     * @return string
     */
    public function actionAdd($product_id)
    {
        $product = $this->findModel($product_id, Product::class, true, '_id');
        $skuName = $this->request->post('product_sku');
        $qty = $this->request->post('qty', 1);
        $data = [];
        try {
            if(($sku = $product->getSkuModel($skuName)) === null) {
                throw new UserException('Invalid options');
            }
            $cart = $this->getCustomer()->getCart();
            $cart->addItem($product, $sku, $qty);
            $data['success'] = true;
        } catch(UserException $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        } catch(\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Server error';
        } catch(\Throwable $e) {
            $data['success'] = false;
            $data['message'] = 'Server error';
        }
        return $this->asJson($data);
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
     * 移除购物车中的一条
     * 
     * @param  int $id   
     * @return string
     */
    public function actionRemoveItem( $id )
    {
         $item = $this->findModel($id, CartItem::class);
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
        $data = ['success' => false];
        $item = $this->findModel($id, CartItem::class, false);
        if(!$item) {
            $data['message'] = Yii::t('app', 'Item not found');
            return $this->asJson($data);
        }
        $skuModel = $item->getSkuModel();
        if(!$skuModel) {
            $data['message'] = Yii::t('app', 'Product removed');
            return $this->asJson($data);
        }
        
        $qty = $this->request->post('qty');
        if(!$qty || !is_numeric($qty) || $qty < 1 ) {
            $data['message'] = Yii::t('app', 'Invalid qty number');
            return $this->asJson($data);
        }
        $qty = (int) $qty;
        if($skuModel->stock < $qty) {
            $data['message'] = Yii::t('app', 'Inventory is beyond');
            return $this->asJson($data);            
        }
        $item->qty = $qty;
        $item->save();
        $data = [
            'success' => true,
            'data' => [
                'qty'   => $item->qty,
                'price' => $item->getPrice(),
            ],
        ];
        return $this->asJson($data);
    }
}