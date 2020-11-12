<?php

namespace issue\backend\controllers;

use Yii;
use backend\controllers\Controller;
use issue\models\Category;
use issue\models\filters\CategoryFilter;

/**
 * 问题分类控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryController extends Controller
{


    /**
     * 列出问题分类
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
     * 新建分类。
     */
    public function actionCreate()
    {
        $model = new Category();
        $model->insertMode();
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('操作成功！');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }


    /**
     * 更新问题分类
     *
     * @param  $id  分类 ID
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, Category::class);
        $model->updateMode();
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('操作成功！');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }


    /**
     * 删除问题分类。
     * 
     * @param  int $id  分类 ID
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id, Category::class, false);
        if($model) {
            $model->virtualDelete();
        }
        $this->_success('操作成功！');
        return $this->redirect(['index']);
    }

}