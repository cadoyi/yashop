<?php

namespace wishlist\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use wishlist\models\filters\WishlistProductFilter;
use catalog\models\Product;

/**
 * wishlist product controller
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductController extends Controller
{

    public $layout = 'customer';


    /**
     * @inheritdoc
     */
    public function access()
    {
        return [
            'except' => ['add'],
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
        $filterModel = new WishlistProductFilter(['wishlist' => $wishlist]);
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
    public function actionAdd($product_id)
    {
        if($this->user->isGuest) {
            return $this->asJson(['success' => false, 'message' => 'Please login first']);
        }
        $cancel = (int) $this->request->post('cancel', 0);
        
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
            $collection = $wishlist->getProductCollection();

            if(!$cancel) {
                $item = $collection->addProduct($product);
            } else {
                $collection->removeProduct($product);
            }
            $wishlist->save();            
        } catch(\Exception $e) {
            $data = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
            return $this->asJson($data);
        }

        return $this->asJson(['success' => true, 'canceled' => $cancel]);
    }



    /**
     * 删除
     *
     * @param  int $item_id  Wishlist item id
     */
    public function actionDelete($id)
    {
        $collection = $this->identity->wishlist->getProductCollection();
        $collection->removeItem($id);
        $this->_success('Wishlist product removed');
        return $this->redirect(['index']);
    }

}