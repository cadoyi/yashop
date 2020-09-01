<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\models\Product;
use catalog\models\filters\ProductFilter;

/**
 * 删除的产品控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class DeletedProductController extends Controller
{


    /**
     * 删除的产品列表
     */
    public function actionIndex()
    {
         $filterModel = new ProductFilter(['filterDeleted' => true]);
         $dataProvider = $filterModel->search($this->request->get());
         return $this->render('index', [
             'filterModel'  => $filterModel,
             'dataProvider' => $dataProvider,
         ]);
    }



    /**
     * 恢复产品
     * 
     * @param  int $id  产品 ID
     */
    public function actionRestore( $id )
    {
        $product = $this->findProduct( $id );
        if($product->is_deleted) {
            $product->is_deleted = 0;
            $product->deleted_at = null;
            $product->save();
        }
        $this->_success('Product restored');
        return $this->redirect(['/catalog/product/index']);
    }



    /**
     * 永久删除.
     * 
     * @param  int $id  产品 ID
     */
    public function actionDelete( $id )
    {
        $product = $this->findProduct($id, false);
        if($product) {
            $product->delete();
        }
        $this->_success('Product removed');
        return $this->redirect(['index']);
    }




    /**
     * 查找产品.
     * 
     * @param  int  $id    产品 ID
     * @param  boolean $throw 是否抛出异常
     * @return  Product 
     */
    public function findProduct($id, $throw = true)
    {
        return $this->findModel($id, Product::class, $throw);
    }

}