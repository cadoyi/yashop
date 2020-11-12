<?php

namespace issue\backend\controllers;

use Yii;
use backend\controllers\Controller;
use issue\models\filters\ContentFilter;
use issue\models\Category;
use issue\models\Menu;
use issue\models\Content;

/**
 * 问题内容。
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ContentController extends Controller
{


    /**
     * 列出内容。
     * 
     * @param  int   $mid  菜单 ID
     */
    public function actionIndex($mid)
    {
        $menu = $this->findModel($mid, Menu::class, false);
        $filterModel = new ContentFilter([
            'menu' => $menu,
        ]);
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('index', [
            'menu'         => $menu,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 新增问题。
     * 
     * @param  int  $mid   菜单 ID
     */
    public function actionCreate($mid)
    {
        $menu = $this->findModel($mid, Menu::class);
        $model = new Content([
            'category' => $menu->category,
            'menu'     => $menu,
        ]);
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('操作成功！');
            return $this->redirect(['index', 'mid' => $menu->id]);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }



    /**
     * 更新问题
     * 
     * @param  int $mid   问题菜单 ID
     * @param  int  $id   问题 ID
     */
    public function actionUpdate($mid, $id)
    {
        $menu = $this->findModel($mid, Menu::class);
        $model = $this->findModel($id, Content::class);
        if($model->menu_id !== $menu->id) {
            return $this->notFound();
        }
        $model->menu = $menu;
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('操作成功！');
            return $this->redirect(['index', 'mid' => $menu->id]);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);

    }



    /**
     * 删除问题。
     * 
     * @param  int $mid   问题菜单 ID
     * @param  int  $id   问题 ID
     */
    public function actionDelete($mid, $id)
    {
        $menu = $this->findModel($mid, Menu::class);
        $model = $this->findModel($id, Content::class);
        if($model) {
            if($model->menu_id !== $menu->id) {
                return $this->notFound();
            }
            $model->virtualDelete();
        }
        $this->_success('操作成功！');
        return $this->redirect(['index', 'mid' => $menu->id]);
    }





}