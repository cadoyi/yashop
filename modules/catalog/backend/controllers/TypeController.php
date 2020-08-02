<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\models\Type;
use catalog\models\filters\TypeFilter;
use catalog\backend\vms\type\Edit;
use catalog\backend\vms\type\Index;


/**
 * 产品类型控制器.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TypeController extends Controller
{


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
     * 列出产品类型
     */
    public function actionIndex()
    {
        $filterModel = new TypeFilter();
        $dataProvider = $filterModel->search($this->request->post());

        return $this->render('index', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 新产品类型
     */
    public function actionCreate()
    {
        $model = new Type();
        $model->insertMode();

        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Product type saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }



    /**
     * 更新产品类型
     * 
     * @param  int  $id  产品类型 ID
     */
    public function actionUpdate( $id )
    {
        $model = $this->findModel($id, Type::class);
        $model->updateMode();

        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Product type saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);

    }





    /**
     * 删除产品类型
     * 
     * @param  int  $id   产品类型 ID
     */
    public function actionDelete( $id )
    {
        $model = $this->findModel($id, Type::class);
        $model->delete();
        $this->_success('Product type deleted');
        return $this->redirect(['index']);
    }



}