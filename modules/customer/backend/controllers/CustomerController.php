<?php

namespace customer\backend\controllers;

use Yii;
use backend\controllers\Controller;
use customer\models\Customer;
use customer\models\filters\CustomerFilter;
use customer\models\filters\CustomerAccountFilter;
use customer\models\filters\CustomerOauthFilter;
use customer\backend\models\customer\Create;
use customer\backend\models\customer\Password;
use customer\backend\models\customer\AddAccount;


/**
 * 客户用户控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerController extends Controller
{



    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
            'delete'          => ['post'],
            'delete-account'  => ['post'],
            'delete-oauth'    => ['post'],
        ];
    }


    /**
     * 列出用户
     */
    public function actionIndex()
    {
        $filterModel = new CustomerFilter();
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('index', compact('filterModel', 'dataProvider'));
    }



    /**
     * 新建用户
     */
    public function actionCreate()
    {
        $model = new Create();
        if($model->load($this->request->post()) &&  $model->save()) {
            $customer = $model->customer;
            $this->_success('Customer saved');
            if($this->request->post('continue', 0)) {
                return $this->redirect(['update', 'id' => $customer->id ]);
            }
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * 更新用户
     *
     * @param  int $id  用户 ID
     */
    public function actionUpdate($id)
    {
         $customer = $this->findModel($id, Customer::class);
         if($customer->load($this->request->post()) && $customer->save()) {
            $this->_success('Customer saved');
            return $this->refresh();
         }
         return $this->render('update', [
             'customer' => $customer,
         ]);
    }




    /**
     * 更新账户密码信息
     * 
     * @param  int  $id Customer ID
     */
    public function actionPassword($id)
    {
        $customer = $this->findModel($id, Customer::class);
        $url = ['update-account', 'id' => $customer->id];
        $model = new Password(['customer' => $customer]);
        if(!$model->canChangePassword()) {
            $this->_error('No account can do this operation');
            return $this->redirect($url);
        }
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Customer password saved');
            return $this->refresh();
        }
        return $this->render('password', [
            'customer' => $customer,
            'model'    => $model,
        ]);
    }       

    


    /**
     * 账户信息更改.
     * 
     * @param  int  $id   Customer ID
     */
    public function actionAccount($id)
    {
        $customer = $this->findModel($id, Customer::class);
        $filterModel = new CustomerAccountFilter(['customer' => $customer]);
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('account', [
            'customer'     => $customer,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }





    /**
     * 绑定手机/邮件账号
     * 
     * @param  int $id  Customer ID
     * @param  string $type   email 或者 phone
     */
    public function actionAddAccount($id, $type)
    {
        $customer = $this->findModel($id, Customer::class);
        $model = new AddAccount([
              'customer' => $customer,
              'type'     => $type,
        ]);
        if(!$model->isTypeValid()) {
            return $this->notFound();
        }
        if(!$model->canAddAccount()) {
            $this->_error('Cannot add this account type');
            return $this->redirect(['account', 'id' => $customer->id]);
        }
        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Account binded');
            return $this->redirect(['account', 'id' => $customer->id]);
        }
        return $this->render('add-account', [
            'customer' => $customer,
            'model'    => $model,
        ]);
    }




    /**
     * 删除指定的账户.
     * 
     * @param  int $cid    Customer ID
     * @param  int $id     CustomerAccount ID
     */
    public function actionDeleteAccount($cid, $id)
    {
        $customer = $this->findModel($cid, Customer::class);
        $url = ['account', 'id' => $customer->id ];
        if(!$customer->typePhone || !$customer->typeEmail) {
            $this->_error('You must have lastest one Phone or email account');
            return $this->redirect($url);
        }
        if($customer->typePhone->id != $id && $customer->typeEmail != $id) {
            return $this->notFound();
        }
        if($customer->typePhone->id == $id) {
            $customer->typePhone->delete();
        } else {
            $customer->typeEmail->delete();
        }
        $this->_success('Customer account deleted');
        return $this->redirect($url);
    }






    /**
     * 列出 oauth 账户
     * 
     */
    public function actionOauth($id)
    {
        $customer = $this->findModel($id, Customer::class);

        $filterModel = new CustomerOauthFilter([
            'customer' => $customer,
        ]);
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('oauth', [
            'customer'     => $customer,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }




    /**
     * 删除 oauth 账户.
     * 
     * @param  int  $cid  Customer ID
     * @param  int  $id   CustomerOauth ID
     * 
     * @todo 暂时没有数据
     */
    public function actionDeleteOauth($cid, $id)
    {
        return $this->notFound();
    }




    /**
     * 删除用户
     *
     * @param  int $id  用户 ID
     */
    public function actionDelete($id)
    {
        $customer = $this->findModel($id, Customer::class);
        $customer->delete();
        $this->_success('Customer deleted');
        return $this->redirect(['index']);
    }




}