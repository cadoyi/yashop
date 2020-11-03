<?php

namespace admin\backend\controllers;

use Yii;
use backend\controllers\Controller;
use admin\models\filters\UserFilter;
use admin\backend\models\user\Edit;
use admin\models\User;

/**
 * 用户控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class UserController extends Controller
{


    /**
     * 用户 grid
     */
    public function actionIndex()
    {
        $filterModel = new UserFilter();
        $dataProvider = $filterModel->search($this->request->get());        
        return $this->render('index', [
           'filterModel' => $filterModel,
           'dataProvider' => $dataProvider,
        ]);
    }




    /**
     * 创建管理员
     */
    public function actionCreate()
    {
        $user = new Edit();
        $user->insertMode();

        if($user->load($this->request->post()) && $user->saveUser()) {
            $this->_success('New user added');
            $this->log('Add user: {username}', [
                'username' => $user->username,
            ]);
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $user,
        ]);
    }



    /**
     * 更新管理员
     * 
     * @param  int $id  用户 ID
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id, Edit::class);
        $user->updateMode();
        if($user->load($this->request->post()) && $user->saveUser()) {
            $this->_success('User saved');
            $this->log('Edit user: {username}', [
                'username' => $user->username,
            ]);
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'model' => $user,
        ]);
    }




    /**
     * 删除用户
     * 
     * @param  int $id   用户 ID
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id, User::class);
        if($user->canDelete()) {
            $this->_success('User deleted');
            $this->log('Delete user: {username}', [
                'username' => $user->username,
            ]);
            $user->delete();
        } else {
            $this->_error('This user cannot be deleted');
            $this->log('Faild delete user: {username}', [
                'username' => $user->username,
            ]);
        }
        return $this->redirect(['index']);
    }




    /**
     * 管理员日志
     * 
     * @param  int $id  用户 ID
     */
    public function actionLog($id)
    {
        $user = $this->findModel($id, User::class);
        $filter = new UserLogFilter(['user' => $user]);
        $get = Yii::$app->request->get($filter->formName());
        $get['user_id'] = $user->id;
        $params = [
            $filter->formName() => $get,
        ];
        $dataProvider = $filter->search($params);
        return $this->render('log', [
            'filterModel' => $filter,
            'dataProvider' => $dataProvider,
        ]);
    }
 

    /**
     * 编辑用户角色
     * 
     * @param  int $id  用户 ID
     */
    public function actionRole($id)
    {
        $user = $this->findModel($id, User::class);

        return $this->render('role', [
            'user' => $user,
        ]);
    }


}