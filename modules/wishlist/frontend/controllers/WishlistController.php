<?php

namespace wishlist\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use wishlist\models\filters\WishlistItemFilter;
use catalog\models\Product;

/**
 * wishlist controller
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class WishlistController extends Controller
{
    public $layout = 'customer';


    /**
     * @inheritdoc
     */
    public function access()
    {
        return [
            'except' => ['add-product'],
            'rules' => [
                [
                    'allow' => false,
                    'roles' => ['?'],
                ],
                [
                ],
            ],
        ]; 
    }


    /**
     * 列出 wishlist
     */
    public function actionIndex()
    {
        $customer = $this->identity;
        $wishlist = $customer->getWishlist();
        $filterModel = new WishlistItemFilter(['wishlist' => $wishlist]);
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('index', [
            'wishlist'     => $wishlist,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 添加产品
     * 
     * @param  string $product_id  产品 ID
     */
    public function actionAddProduct()
    {
        if($this->user->isGuest) {
            return $this->asJson(['success' => false, 'message' => 'Please login first']);
        }
        $product_id = $this->request->post('product_id');
        $cancel = (int) $this->request->post('cancel');
        
        $product = $this->findModel($product_id, Product::class);
        if($product === false) {
            return $this->asJson([
                'success' => false, 
                'message' => 'Product not found.'
            ]);
        }
        try {
            $customer = $this->identity;
            $wishlist = $customer->getWishlist();
            if(!$cancel) {
                $wishlist->addProduct($product);
            } else {
                $wishlist->removeProduct($product);
            }
            $wishlist->save();            
        } catch(\Exception $e) {
            $data = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $this->asJson(['success' => true, 'canceled' => $cancel]);
    }



    /**
     * 删除
     *
     * @param  int $item_id  Wishlist item id
     */
    public function actionDelete($item_id)
    {
        $customer = $this->identity;
        $wishlist = $customer->getWishlist();
        $item = $wishlist->getItems()
            ->andWhere(['id' => $item_id])
            ->one();
        if(!$item) {
            return $this->notFound();
        }
        $item->delete();
        $this->_success('Wishlist item deleted');
        return $this->redirect(['index']);
    }

}