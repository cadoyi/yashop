<?php


namespace front\backend\controllers;

use Yii;
use backend\controllers\Controller;
use front\models\Menu;
use front\models\MenuItem;
use front\models\filters\MenuItemFilter;


/**
 * manage menu item
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class MenuItemController extends Controller
{


    /**
     * 列出菜单项
     */
    public function actionIndex( $menu_id )
    {
        $menu = $this->findModel($menu_id, Menu::class);
        $filterModel = new MenuItemFilter(['menu' => $menu]);
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'menu'         => $menu,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 增加菜单项
     * 
     * @param  int  $menu_id  菜单 ID
     */
    public function actionCreate($menu_id)
    {
         $menu = $this->findModel($menu_id, Menu::class);
         $model = new MenuItem(['menu_id' => $menu->id]);
         $model->insertMode();

         if($model->load($this->request->post()) && $model->save()) {
             $this->_success('Menu item saved');
             return $this->redirect(['index', 'menu_id' => $menu->id]);
         }
         return $this->render('edit', [
            'menu' => $menu,
            'model' => $model,
         ]);
    }



    public function actionUpdate( $id )
    {
        $model = $this->findModel($id, MenuItem::class);
        $menu = $model->menu;
        $model->updateMode();
         if($model->load($this->request->post()) && $model->save()) {
             $this->_success('Menu item saved');
             return $this->redirect(['index', 'menu_id' => $menu->id]);
         }
         return $this->render('edit', [
            'menu' => $menu,
            'model' => $model,
         ]);

    }


    public function actionDelete( $id )
    {

    }



}