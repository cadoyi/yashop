<?php

namespace admin\backend\controllers;

use Yii;
use backend\controllers\Controller;
use cando\rbac\models\RoleFilter;
use cando\rbac\models\Role;
use cando\rbac\models\RoleForm;

/**
 * 角色控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class RoleController extends Controller
{


    /**
     * grid
     */
    public function actionIndex()
    {
        $filterModel = new RoleFilter();
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 新建
     */
    public function actionCreate()
    {
        $model = new RoleForm();
        if($model->load($this->request->post()) && $model->saveRole()) {
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }


    /**
     * 更新 role
     * 
     * @param  string $name 角色名
     * @return string
     */
    public function actionUpdate($name)
    {
        $model = $this->findRole($name, true, RoleForm::class);
        if($model->load($this->request->post()) && $model->saveRole()) {
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $model,
        ]);        
    }



    /**
     * 删除角色
     * 
     * @param  string $name 角色名
     * @return string
     */
    public function actionDelete($name)
    {
        $model = $this->findRole($name);
        $model->delete();
        return $this->redirect(['index']);
    }



    /**
     * 查找角色
     * 
     * @param  string  $name  角色名
     * @param  boolean $throw 是否抛出异常
     * @return Role
     */
    public function findRole($name, $throw = true, $class = null)
    {
        if($class === null) {
            $class = Role::class;
        }
        return $this->findModel($name, $class, $throw, 'name');
    }

}