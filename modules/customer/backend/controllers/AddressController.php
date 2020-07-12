<?php

namespace customer\backend\controllers;

use Yii;
use backend\controllers\Controller;
use customer\models\Customer;
use customer\models\CustomerAddress;
use customer\models\filters\CustomerAddressFilter;


/**
 * 地址控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AddressController extends Controller
{


    /**
     * 地址管理
     * 
     * @param  int $cid  customer ID
     */
    public function actionIndex($cid)
    {
        $customer = $this->findModel($cid, Customer::class);
        $filterModel = new CustomerAddressFilter(['customer' => $customer]);
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('index', [
           'customer' => $customer,
           'filterModel' => $filterModel,
           'dataProvider' => $dataProvider,
        ]);
    }




    /**
     * 新增地址
     * 
     * @param  int  $cid   Customer ID
     */
    public function actionCreate($cid)
    {
         $customer = $this->findModel($cid, Customer::class);
         $address = new CustomerAddress(['customer' => $customer]);

         $address->insertMode();
         if($address->load($this->request->post()) && $address->save()) {
             $this->_success('Address saved');
             return $this->redirect(['index', 'cid' => $customer->id]);
         }
         return $this->render('edit', [
             'customer' => $customer,
             'address'    => $address,
         ]);
    }


    /**
     * 更新地址
     * 
     * @param  int  $cid  Customer ID
     * @param  int   $id  Address ID
     */
    public function actionUpdate($cid, $id)
    {
         $customer = $this->findModel($cid, Customer::class);
         $address = $this->findModel($id, CustomerAddress::class);
         if($address->customer_id != $customer->id) {
             return $this->notFound();
         }
         $address->updateMode();
         if($address->load($this->request->post()) && $address->save()) {
             $this->_success('Address saved');
             return $this->redirect(['index', 'cid' => $customer->id]);
         }
         return $this->render('edit', [
             'customer' => $customer,
             'address'    => $address,
         ]);         
    }



    /**
     * 删除地址
     * 
     * @param  int  $cid  Customer ID
     * @param  int  $id   Address ID
     */
    public function actionDelete($cid, $id)
    {
        $customer = $this->findModel($cid, Customer::class);
        $address = $this->findModel($id, CustomerAddress::class);
        if($customer->id != $address->customer_id) {
            return $this->notFound();
        }
        if($address->isDefault()) {
            $this->_error('Cannot delete the default address');
            return $this->redirect(['index', 'cid' => $customer->id]);
        }
        $address->delete();
        $this->_success('Address deleted');
        return $this->redirect(['index', 'cid' => $customer->id ]);
    }


    

}