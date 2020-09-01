<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\models\Product;
use catalog\models\ProductSku;
use catalog\backend\models\ProductSkuForm;
use catalog\models\filters\ProductSkuFilter;

/**
 * 产品 SKU 控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductSkuController extends Controller
{


    /**
     * 列出产品的 SKU
     * 
     * @param  int $pid   产品 ID
     */
    /*
    public function actionIndex($pid)
    {
        $product = $this->findProduct($pid);
        $filterModel = new ProductSkuFilter(['product' => $product]);
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'product'      => $product,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    } */



    /**
     * 新建产品 SKU
     * 
     * @param  int $pid   产品 ID
     */
    public function actionCreate($pid)
    {
        $product = $this->findProduct($pid);
        $model = new ProductSkuForm(['product' => $product]);
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Product sku saved');
            return $this->redirect(['/catalog/product/update', 'id' => $product->id]);
        }
        return $this->render('edit', [
            'product' => $product,
            'model'   => $model,
        ]);
    }




    /**
     * 增加产品的 SKU
     * 
     * @param  int $pid   产品 ID
     * @param  int $id    sku ID
     */
    public function actionUpdate($pid, $id)
    {
        $product = $this->findProduct($pid);
        $productSku = $this->findProductSku($id, $product);
        $model = new ProductSkuForm(['product' => $product, 'productSku' => $productSku]);
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Product sku saved');
            return $this->redirect(['/catalog/product/update', 'id' => $product->id]);
        }
        return $this->render('edit', [
            'product' => $product,
            'model'   => $model,
        ]);
    }



    /**
     * 删除产品的 SKU
     * 
     * @param  int $pid   产品 ID
     * @param  int $id    SKU ID
     */
    public function actionDelete($pid, $id)
    {
         $product = $this->findProduct($pid);
         $productSku = $this->findProductSku($id, $product, false);
         if($productSku) {
            $productSku->delete();
         } 
         $this->_success('Product sku deleted');
         return $this->redirect(['/catalog/product/update', 'id' => $product->id]);
    }




    /**
     * 查找产品
     * 
     * @param  int $id      产品 ID
     * @return Product
     */
    public function findProduct( $id )
    {
        $product = $this->findModel($id, Product::class, false);
        if(!$product || $product->is_deleted) {
            return $this->notFound();
        }
        return $product;
    }



  
    /**
     * 查找产品 SKU
     * 
     * @param  int    $id       产品 SKU ID
     * @param  Product  $product 产品
     * @param  boolean $throw    是否抛出异常
     * @return ProductSku
     */
    public function findProductSku($id, $product, $throw = true)
    {
        $sku = ProductSku::findOne([
            'id' => $id,
            'product_id' => $product->id,
        ]);
        return $sku ?? ($throw ? $this->notFound() : null);
    }

}