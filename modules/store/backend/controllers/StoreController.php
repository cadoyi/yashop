<?php

namespace store\backend\controllers;

use Yii;
use backend\controllers\Controller;
use store\models\Store;
use store\models\filters\StoreFilter;

/**
 * 店铺控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class StoreController extends Controller
{


    /**
     * store 列表页
     */
    public function actionIndex()
    {
        $filterModel = new StoreFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }




    /**
     * 增加 store
     */
    public function actionCreate()
    {
        $model = new Store();
        $model->insertMode();

        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Store created');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }



    /**
     * 更新 store
     * 
     * @param  int $id  store id
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, Store::class);
        $model->updateMode();

        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Store saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }



    /**
     * 删除 store
     * 
     * @param  int  $id  store ID
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id, Store::class);
        $model->delete();
        $this->_success('Store deleted');
        return $this->redirect(['index']);
    }


}