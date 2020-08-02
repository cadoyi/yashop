<?php

namespace cms\backend\controllers;

use Yii;
use backend\controllers\Controller;
use cms\models\filters\ArticleFilter;
use cms\backend\models\article\Edit;
use cms\backend\vms\article\IndexModel;
use cms\backend\vms\article\EditModel;


/**
 * 文章控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ArticleController extends Controller
{


    /**
     * @inheritdoc
     */
    public function viewModels()
    {
        return [
            'index' => [
                 'class' => IndexModel::class,
            ],
            'create' => [
                 'class' => EditModel::class,
            ],
            'update' => [
                 'class' => EditModel::class,
            ],
        ];
    }


    /**
     * 文章 grid
     */
    public function actionIndex()
    {
        $filterModel = new ArticleFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 增加新文章
     */
    public function actionCreate()
    {
         $model = new Edit();
         return $this->edit($model);
    }



    /**
     * 更新文章
     * 
     * @param  int  $id  文章 ID
     */
    public function actionUpdate($id)
    {
         $model = $this->findModel($id, Edit::class);
         return $this->edit($model);
    }



    /**
     * 编辑文章.
     * 
     * @param  Article $model 
     */
    protected function edit( $model )
    {
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Article saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }



    /**
     * 删除文章
     * 
     * @param  int  $id  文章 ID
     */
    public function actionDelete($id)
    {

    }


}