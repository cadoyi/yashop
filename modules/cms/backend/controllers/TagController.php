<?php

namespace cms\backend\controllers;

use Yii;
use backend\controllers\Controller;
use cms\models\filters\TagFilter;
use cms\models\Tag;

/**
 * tag controller
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TagController extends Controller
{


    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
            'delete'      => ['post'],
            'ajax-create' => ['post'],
        ];
    }



    /**
     * 列出所有标签
     */
    public function actionIndex()
    {
        $filterModel = new TagFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 增加 tag
     */
    public function actionCreate()
    {
        $model = new Tag();
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Article tag saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }



    /**
     * 更新文章标签.
     * 
     * @param  int $id   文章标签 ID
     */
    public function actionUpdate( $id )
    {
        $model = $this->findModel($id, Tag::class);
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Article tag saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);        
    }



    /**
     * 删除标签
     * 
     * @param  int  $id  标签 ID
     */
    public function actionDelete( $id )
    {
        $tag = $this->findModel($id, Tag::class);
        $tag->delete();
        $this->_success('Article tag deleted');
        return $this->redirect(['index']);
    }




}