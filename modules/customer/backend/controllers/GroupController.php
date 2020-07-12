<?php

namespace customer\backend\controllers;

use Yii;
use backend\controllers\Controller;
use customer\models\filters\CustomerGroupFilter;
use customer\models\CustomerGroup;

/**
 * 客户组控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class GroupController extends Controller
{


    /**
     * 列出和搜索客户组
     */
    public function actionIndex()
    {
        $filterModel = new CustomerGroupFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }




    /**
     * 新建客户组
     */
    public function actionCreate()
    {
        $model = new CustomerGroup();
        $model->insertMode();
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Customer group saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
           'model' => $model,
        ]);
    }



    /**
     * 更新客户组
     * 
     * @param  int $id  客户组 ID
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, CustomerGroup::class);
        $model->updateMode();
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Customer group saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
           'model' => $model,
        ]);        
    }



    /**
     * 删除客户组
     * 
     * @param  int $id   客户组 ID
     * @return string
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id, CustomerGroup::class);
        if($model->canDelete()) {
            $model->delete();
        } else {
            $this->_error('Cannot delete the default group');
        }
        return $this->redirect(['index']);
    }




}