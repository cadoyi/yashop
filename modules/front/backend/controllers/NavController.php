<?php

namespace front\backend\controllers;

use Yii;
use backend\controllers\Controller;
use front\models\Nav;
use front\backend\vms\nav\Load;

/**
 * Nav 菜单控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class NavController extends Controller
{



    /**
     * @inheritdoc
     */
    public function verbs()
    {
         return [
             'load' => ['post', 'get'],
             'create' => ['post'],
             'update' => ['post'],
             'sort'   => ['post'],
             'delete' => ['post'],
         ];
    }



    /**
     * @inheritdoc
     */
    public function ajax()
    {
        return ['load', 'create', 'update', 'sort', 'delete'];
    }




    /**
     * 列出菜单.
     */
    public function actionIndex()
    {
        return $this->render('index');
    }



    /**
     *  ajax 加载
     *  
     * @param  int  $id  
     * @return array
     */
    public function actionLoad( $id )
    {
        if($id === '#') {
            $navs = Nav::find()
                ->andWhere(['parent_id' => 0])
                ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
                ->all();
        } else {
            $nav = $this->findModel($id, Nav::class, false);
            if($nav === false) {
                $navs = [];
            } else {
                $navs = $nav->childs; 
            }
        }
        $model = new Load([ 'navs' => $navs ]);
        return $this->asJson($model);
    }




    /**
     * 新增菜单.
     */
    public function actionCreate()
    {
        $pid = $this->request->post('parent');
        if($pid === '#') {
            $parent = null;
        } else {
            $parent = $this->findModel($pid, Nav::class);
        }
        $nav  = new Nav([
           'parent_id' => $parent ?  $parent->id : null,
           'title'     => '新菜单',
        ]);
        if($nav->save()) {
            $load = new Load();
            $data = $load -> getJsonData($nav);
            return $this->success($data);
        } else {
            return $this->error($nav);
        }
    }


    /**
     * 更新菜单.主要是用于重命名。
     * 
     * @param  int  $id  菜单 ID
     */
    public function actionUpdate()
    {
        $id = $this->request->post('id');
        $title = $this->request->post('title');
        $nav = $id ? $this->findModel($id, Nav::class, false) : null;
        if(!$nav) {
            return $this->error('菜单已经不存在');
        }
        $nav->title = $title;
        $nav->save();
        return $this->success();
    }



    /**
     * 菜单排序。
     * 
     * @return json
     */
    public function actionSort()
    {
        $ids = $this->request->post('ids');
        $navs = Nav::find()
            ->andWhere(['id' => $ids])
            ->indexBy('id')
            ->all();
        $trans = Nav::getDb()->beginTransaction();
        try {
            foreach($ids as $k => $id) {
                $nav = $navs[$id];
                $nav->sort_order = $k;
                $nav->save();
            }
            $trans->commit();
            
        } catch(\Exception | \Throwable $e) {
            $trans->rollBack();
            return $this->error($e);
        }
        return $this->success();
    }



    /**
     * 删除菜单.
     * 
     * @param  int  $id   菜单 ID
     */
    public function actionDelete()
    {
        $id = $this->request->post('id');
        $model = $id ? $this->findModel($id, Nav::class, false) : false;
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