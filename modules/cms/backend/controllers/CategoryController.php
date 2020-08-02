<?php

namespace cms\backend\controllers;

use Yii;
use backend\controllers\Controller;
use cms\models\filters\CategoryFilter;
use cms\models\Category;



/**
 * 文章分类控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryController extends Controller
{



    /**
     *  grid 列表
     */
    public function actionIndex()
    {
        $filterModel = new CategoryFilter();
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('index', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 创建文章分类
     */
    public function actionCreate()
    {
        $model = new Category();
        return $this->edit($model);
    }




    /**
     * 编辑文章分类
     * 
     * @param  Category $model 
     * @return string
     */
    public function edit( $model )
    {
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Article category saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }



    /**
     * 更新文章分类
     * 
     * @param  int  $id  文章分类 ID
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, Category::class);
        return $this->edit($model);
    }





    /**
     * 删除文章分类
     * 
     * @param  int  $id  文章分类 ID
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id, Category::class);
        $model->delete();
        $this->_success('Article category deleted');
        return $this->redirect(['index']);
    }



}