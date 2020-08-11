<?php

namespace front\backend\controllers;

use Yii;
use backend\controllers\Controller;
use front\models\filters\MenuFilter;
use front\models\Menu;

/**
 * 菜单控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class MenuController extends Controller
{


    /**
     * 列出菜单
     */
    public function actionIndex()
    {
        $filterModel = new MenuFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * 增加菜单
     */
    public function actionCreate()
    {
        $model = new Menu();
        $model->insertMode();
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Menu saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }



    /**
     * 更新菜单
     * 
     * @param  string $id  菜单 ID
     */
    public function actionUpdate( $id )
    {
         $model = $this->findModel($id, Menu::class);
         $model->updateMode();
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Menu saved');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);         
    }


    /**
     * 删除菜单
     * 
     * @param  string $id  菜单 ID
     */
    public function actionDelete( $id )
    {
        $menu = $this->findModel($id, Menu::class);
        $menu->delete();
        $this->_success('Menu removed');
        return $this->redirect(['index']);
    }



}