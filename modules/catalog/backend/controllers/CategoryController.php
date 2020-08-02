<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\backend\vms\category\Load;
use catalog\backend\vms\category\Index;
use catalog\backend\vms\category\Edit;
use catalog\models\Category;
use catalog\models\filters\CategoryFilter;

/**
 * 产品分类控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryController extends Controller
{



    /**
     * @inheritdoc
     */
    public function verbs()
    {
         return [];
    }



    /**
     * @inheritdoc
     */
    public function ajax()
    {
        return ['load'];
    }


    
    /**
     * @inheritdoc
     */
    public function viewModels()
    {
        return [
            'index'  => Index::class,
            'create' => Edit::class,
            'update' => Edit::class,
        ];
    }




    /**
     * 列出分类.
     */
    public function actionIndex()
    {
        $filterModel = new CategoryFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     *  ajax 加载
     *  
     * @param  int  $id  
     * @return array
     */
    public function actionLoad( $id )
    {
        if($id === '#') {
            $categories = Category::find()
                ->andWhere(['parent_id' => null])
                ->orderBy(['sort_order' => SORT_ASC ])
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
     * 新增分类.
     */
    public function actionCreate( $parent = null )
    {
        if($parent !== null) {
            $parent = $this->findModel($parent, Category::class);
        }
        $model = new Category([
           'parent_id' => is_null($parent) ? null : $parent->id,
        ]);
        $model->insertMode();
        
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Category saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
           'model' => $model,
        ]);
    }


    /**
     * 更新分类.
     * 
     * @param  int  $id  分类 ID
     */
    public function actionUpdate( $id )
    {
        $model = $this->findModel($id, Category::class);

        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Category saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }



    /**
     * 删除分类.
     * 
     * @param  int  $id   分类 ID
     */
    public function actionDelete( $id )
    {
        $model = $this->findModel($id, Category::class);
        $model->delete();
        $this->_success('Category saved');
        $this->redirect(['index']);
    }


}