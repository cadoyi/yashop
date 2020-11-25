<?php

namespace shop\controllers;

use Yii;
use shop\models\filters\ProductFilter;
use catalog\models\Category;
use catalog\models\Product;
use catalog\models\ProductSku;
use catalog\models\forms\ProductEditForm;
use catalog\models\forms\ProductSkuForm;
use shop\vms\product\CategoryLoad as Load;


/**
 * 产品控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductController extends Controller
{


    /**
     * 产品列表。
     * 
     * @return string
     */
    public function actionIndex()
    {
        $filterModel = new ProductFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 加载分类树。
     */
    public function actionLoadCategories($id)
    {
        if($id === '#') {
            $categories = Category::find()
                ->andWhere(['parent_id' => 0])
                ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
                ->all();
        } else {
            $category = $this->findModel($id, Category::class, false);
            if($category === false) {
                $categories = [];
            } else {
                $categories = $category->childs; 
            }
        }
        $model = new Load([ 'categories' => $categories ]);
        return $this->asJson($model); 

    }



    /**
     * 新增产品
     */
    public function actionCreate($cid = null)
    {
        if(is_null($cid) || !($category = $this->findModel($cid, Category::class))) {
            return $this->render('edit/select_category');
        }

        $product = new Product([
            'category' => $category,
            'store'    => $this->store,
        ]);

        $form = new ProductEditForm([
            'product' => $product,
        ]);

        if($form->load($this->request->post()) && $form->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model' => $form,
        ]);
    }




    /**
     * 更新产品.
     * 
     * @param  int  $id  产品 ID
     * @return string
     */
    public function actionUpdate( $id )
    {
        $product = $this->findModel($id, Product::class);
        $form = new ProductEditForm([
            'product' => $product,
        ]);

        if($form->load($this->request->post()) && $form->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model' => $form,
        ]);
    }



    /**
     * 删除
     * 
     * @param  int   $id  产品 ID
     */
    public function actionDelete( $id )
    {
        $product = $this->findModel($id, Product::class);
        if($product) {
            $product->virtualDelete();
        }
        return $this->redirect(['index']);

    }



    /**
     * 增加 sku
     * 
     * @param  int   $pid  
     * @return boolean
     */
    public function actionAddSku( $pid )
    {
        $product = $this->findModel($pid, Product::class);

        $model = new ProductSkuForm([
            'product' => $product,
        ]);
        $this->performAjaxValidate($model);
        if($model->load($this->request->post()) && $model->save()) {
            return $this->render('result', ['success' => true]);
        }
        return $this->render('edit-sku', [
             'model' => $model,
        ]);
    }



    /**
     * 增加 sku
     * 
     * @param  int   $pid  
     * @return boolean
     */
    public function actionUpdateSku( $pid, $id)
    {
        $product = $this->findModel($pid, Product::class);
        $sku = ProductSku::findOne([
            'product_id' => $product->id,
            'id'       => $id,     
        ]);
        if(!$sku) {
            return $this->notFound();
        }
        $sku->setProduct($product);
        $model = new ProductSkuForm([
            'product' => $product,
            'productSku' => $sku,
        ]);

        $this->performAjaxValidate($model);
        if($model->load($this->request->post()) && $model->save()) {
            return $this->render('result', ['success' => true]);
        }
        return $this->render('edit-sku', [
             'model' => $model,
        ]);
    }



    /**
     * 删除指定的 SKU
     * 
     * @param  int  $pid  产品 ID
     * @param  int  $id   SKU ID
     */
    public function deleteSku($pid, $id)
    {

    }

}