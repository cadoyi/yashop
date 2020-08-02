<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\models\Brand;
use catalog\models\filters\BrandFilter;


/**
 * 品牌控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class BrandController extends Controller
{


    /**
     * brand grid 列表
     */
    public function actionIndex()
    {
        $filterModel = new BrandFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 新建品牌
     */
    public function actionCreate()
    {
         $model = new Brand();
         $model->insertMode();
         return $this->edit($model);
    }


    protected function edit( $model )
    {
         if($model->load($this->request->post()) && $model->save()) {
              $this->_success('Brand saved');
              return $this->redirect(['index']);
         }
         return $this->render('edit', [
             'model' => $model,
         ]);
    }



    
    /**
     * 更新品牌
     * 
     * @param  string $id  品牌 ID
     */
    public function actionUpdate( $id )
    {
        $model = $this->findModel($id, Brand::class);
        $model->updateMode();
        return $this->edit($model);
    }


    
    /**
     * 删除品牌
     * 
     * @param  string $id  品牌 ID
     */
    public function actionDelete( $id )
    {
        $model = $this->findModel($id, Brand::class);
        $model->delete();
        $this->_success('Brand deleted');
        return $this->redirect(['index']);
    }


}