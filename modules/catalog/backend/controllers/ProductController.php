<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\models\Category;
use catalog\models\Product;
use catalog\models\Type;
use catalog\models\filters\ProductFilter;
use catalog\backend\vms\product\SelectCategory;
use catalog\backend\vms\product\Edit;
use catalog\models\forms\TypeAttributeForm;
use cando\base\DynamicModel;


/**
 * 产品控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductController extends Controller
{



    /**
     * @inheritdoc
     */
    public function viewModels()
    {
        return [
            'create' => Edit::class,
            'update' => Edit::class,
        ];
    }


    /**
     * 列出所有产品
     */
    public function actionIndex()
    {
        $filterModel = new ProductFilter(['isDeleted' => 0]);
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('index', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 列出删除的产品
     */
    public function actionDeleted()
    {
        $filterModel = new ProductFilter(['isDeleted' => 1 ]);
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('deleted', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]); 
    }



    /**
     * 添加产品
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

        $product = new Product();
        $product->category_id = $category->id;
        $product->type_id = $type_id;
        $product->insertMode();
        $typeAttributeForm = new TypeAttributeForm([
            'type'    => $type,
            'product' => $product,
        ]);

        if($product->loadForm($this->request->post()) && $product->saveForm()) {
            $this->_success('Product saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
           'category'          => $category,
           'product'           => $product,
           'type'              => $type,
           'typeAttributeForm' => $typeAttributeForm,
        ]);
    }



    /**
     * 更新产品
     * 
     * @param  string $id  产品的 id
     */
    public function actionUpdate( $id )
    {
        $product = $this->findProduct($id);
        $product->updateMode();
        $typeAttributeForm = new TypeAttributeForm([
            'type'    => $product->type,
            'product' => $product,  
        ]);
        $category = $product->category;
        $type = $product->type;

        if($product->loadForm($this->request->post()) && $product->saveForm()) {
            $this->_success('Product saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
           'category'          => $category,
           'product'           => $product,
           'type'              => $type,
           'typeAttributeForm' => $typeAttributeForm,
        ]);
    }




    /**
     * 虚拟产品
     * 
     * @param  string $id 产品 ID
     */
    public function actionDelete( $id )
    {
        $product = $this->findProduct($id, Product::class);
        $product->virtualDelete();
        $this->_success('Product deleted');
        return $this->redirect(['index']);
    }



    /**
     * 将删除的产品进行恢复.
     * 
     * @param  string  $id  产品 ID
     */
    public function actionRestore( $id )
    {
        $product = $this->findProduct($id, Product::class);
        $product->is_deleted = 0;
        $product->save();
        $this->_success('Product restored');
        return $this->redirect(['index']);
    }




    /**
     * 真实删除
     * 
     * @param  string $id  产品 ID
     */
    public function actionRemove( $id )
    {
        $product = $this->findProduct($id, Product::class);
        $product->delete();
        $this->_success('Product deleted');
        return $this->redirect(['index']);
    }




    

    /**
     * @inheritdoc
     */
    public function findProduct($id, $throw = true, $field = '_id')
    {
        return $this->findModel($id, Product::class, $throw, $field);
    }


}