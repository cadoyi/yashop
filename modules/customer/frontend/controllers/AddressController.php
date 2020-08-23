<?php

namespace customer\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use customer\models\filters\CustomerAddressFilter;
use customer\models\CustomerAddress;

/**
 * 客户地址控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AddressController extends Controller
{

    public $layout = 'customer';



    /**
     * @inheritdoc
     */
    public function access()
    {
        return [
            'rules' => [
                [
                    'roles' => ['?'],
                    'allow' => false,
                ],
                [
                    'allow' => true,
                ],
            ],
        ];
    }

    
    /**
     * 地址索引页
     * 
     * @return string
     */
    public function actionIndex()
    {
        $customer = $this->identity;
        $filterModel = new CustomerAddressFilter(['customer' => $customer]);
        $dataProvider = $filterModel->search([]);

        return $this->render('index', [
            'customer' => $customer,
           'filterModel'  => $filterModel,
           'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 新建地址
     */
    public function actionCreate()
    {
         $customer = $this->identity;
         $address = new CustomerAddress(['customer' => $customer]);

         $address->insertMode();
         if($address->load($this->request->post()) && $address->save()) {
             $this->_success('Address saved');
             return $this->redirect(['index']);
         }
         return $this->render('edit', [
             'customer' => $customer,
             'address'    => $address,
         ]);
    }



    /**
     * 更新地址
     * @param  int   $id  Address ID
     */
    public function actionUpdate( $id)
    {
         $customer = $this->identity;
         $address = $this->findModel($id, CustomerAddress::class);
         if($address->customer_id != $customer->id) {
             return $this->notFound();
         }
         $address->updateMode();
         if($address->load($this->request->post()) && $address->save()) {
             $this->_success('Address saved');
             return $this->redirect(['index']);
         }
         return $this->render('edit', [
             'customer' => $customer,
             'address'    => $address,
         ]);         
    }



    /**
     * 删除地址
     * 
     * @param  int  $id   Address ID
     */
    public function actionDelete($id)
    {
        $customer = $this->identity;
        $address = $this->findModel($id, CustomerAddress::class);
        if($customer->id != $address->customer_id) {
            return $this->notFound();
        }
        if($address->isDefault()) {
            $this->_error('Cannot delete the default address');
            return $this->redirect(['index']);
        }
        $address->delete();
        $this->_success('Address deleted');
        return $this->redirect(['index']);
    }



}