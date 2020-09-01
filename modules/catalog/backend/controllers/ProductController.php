<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\models\Product;
use catalog\models\Category;
use catalog\models\Type;
use catalog\models\filters\ProductFilter;
use catalog\models\filters\ProductSkuFilter;
use catalog\backend\vms\product\SelectCategory;
use catalog\backend\models\ProductForm;

/**
 * 产品控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductController extends Controller
{


    /**
     * product list
     */
    public function actionIndex()
    {
         $filterModel = new ProductFilter(['filterDeleted' => false]);
         $dataProvider = $filterModel->search($this->request->get());
         return $this->render('index', [
             'filterModel'  => $filterModel,
             'dataProvider' => $dataProvider,
         ]);
    }



    /**
     * add new product
     */
    public function actionCreate($category_id = null, $type_id = null)
    {
        if(empty($category_id) || empty($type_id)) {
            $model = new SelectCategory([
                 'category_id' => $category_id,
                 'type_id'     => $type_id,
            ]);
            return $this->render('select-category', [
               'model' => $model,
            ]);
        }

        $category = $this->findModel($category_id, Category::class);
        $type = $this->findModel($type_id, Type::class);
        if($type->category_id !== $category->id) {
            $this->_error('Unknown category or type selected');
            return $this->redirect(['create']);
        }

        $product = new Product([
            'category' => $category,
            'type'     => $type,
        ]);

        $product->loadDefaultValues();

        $form = new ProductForm([
            'product'  => $product,
            'type'     => $type,
            'category' => $category,
        ]);
        if($form->load($this->request->post()) && $form->save()) {
            $this->_success('Product saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $form,
        ]);
    }



    /**
     * update product
     * 
     * @param  int $id 产品 ID
     */
    public function actionUpdate( $id )
    {
        $product = $this->findProduct($id, true);
        $product->updateMode();
        $form = new ProductForm([
            'product'  => $product,
            'type'     => $product->type,
            'category' => $product->category,
        ]);
        if($form->load($this->request->post()) && $form->save()) {
            $this->_success('Product saved');
            return $this->redirect(['index']);
        }
        $filterModel = new ProductSkuFilter(['product' => $product]);
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('edit', [
            'model'        => $form,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * delete product
     * 
     * @param  int  $id  产品 ID
     */
    public function actionDelete( $id )
    {
        $product = $this->findProduct($id, false);
        if($product && !$product->is_deleted) {
            $product->virtualDelete();     
        }
        $this->_success('Product removed');
        return $this->redirect(['index']);
    }



    /**
     * 查找产品.
     * 
     * @param  int $id    产品 ID
     * @param  boolean $throw 是否抛出异常
     * @return  Product
     */
    public function findProduct($id, $throw = true)
    {
        return $this->findModel($id, Product::class, $throw);
    }


}