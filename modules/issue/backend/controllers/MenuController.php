<?php

namespace issue\backend\controllers;

use Yii;
use backend\controllers\Controller;
use issue\models\Category;
use issue\models\Menu;
use issue\backend\vms\menu\Load;

/**
 * 问题菜单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class MenuController extends Controller
{


    /**
     * 菜单
     * 
     * @param  int $c   分类 ID
     */
    public function actionIndex($c)
    {
        $category = $this->findModel($c, Category::class);

        return $this->render('index', [
            'category' => $category,
        ]);
    }



    /**
     * 加载子菜单。
     * 
     * @param  int  $c  分类 ID
     */
    public function actionLoad( $c, $id )
    {
        $category = $this->findModel($c, Category::class, false);
        if(!$category) {
            return $this->notFound();
        }
        $parent = ($id === '#' || !$id) ? null : $this->findModel($id, Menu::class);
        $parent_id = $parent ? $parent->id : 0;
        $menus = Menu::find()
            ->andWhere(['category_id' => $category->id])
            ->andWhere(['parent_id' => $parent_id])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();
        if($parent_id === 0 && empty($menus)) {
            $menu = new Menu([
                'category_id' => $category->id,
                'title'       => '新菜单',
            ]);
            $menu->save();
            $menus[] = $menu;
        }
        $load = new Load(['menus' => $menus]);
        
        return $this->asJson($load->toArray());
    }


    /**
     * 新增分类.
     */
    public function actionCreate()
    {
        $pid = $this->request->post('parent');
        $c = $this->request->get('c');
        $category = $this->findModel($c, Category::class);
        if($pid === '#') {
            $parent = null;
        } else {
            $parent = $this->findModel($pid, Menu::class);
        }
        $menu  = new Menu([
           'parent_id' => $parent ? $parent->id : 0,
           'category_id' => $category->id,
           'title'     => '新菜单',
        ]);
        if($menu->save()) {
            $load = new Load();
            $data = $load -> getJsonData($menu);
            return $this->success($data);
        } else {
            return $this->error($menu);
        }
    }


    /**
     * 更新分类.主要是用于重命名。
     * 
     * @param  int  $id  分类 ID
     */
    public function actionUpdate()
    {
        $id = $this->request->post('id');
        $title = $this->request->post('title');
        $menu = $id ? $this->findModel($id, Menu::class, false) : null;
        if(!$menu) {
            return $this->error('菜单已经不存在');
        }
        $menu->title = $title;
        $menu->save();
        return $this->success();
    }



    /**
     * 分类排序。
     * 
     * @return json
     */
    public function actionSort()
    {
        $ids = $this->request->post('ids');
        $menus = Menu::find()
            ->andWhere(['id' => $ids])
            ->indexBy('id')
            ->all();
        $trans = Menu::getDb()->beginTransaction();
        try {
            foreach($ids as $k => $id) {
                $menu = $menus[$id];
                $menu->sort_order = $k;
                if(!$menu->save()) {
                    throw new \Exception(print_r($menu->errors));
                }
            }
            $trans->commit();
            
        } catch(\Exception | \Throwable $e) {
            $trans->rollBack();
            return $this->error($e);
        }
        return $this->success();
    }



    /**
     * 删除分类.
     * 
     * @param  int  $id   分类 ID
     */
    public function actionDelete()
    {
        $id = $this->request->post('id');
        $model = $id ? $this->findModel($id, Menu::class, false) : false;
        if(!$model) {
            return $this->error('菜单不存在');
        }

        if($model->hasChild()) {
            return $this->error('当前菜单有子菜单， 因此不能被删除');
        }
        $model->virtualDelete();
        return $this->success();
    }

}