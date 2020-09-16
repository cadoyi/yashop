<?php

namespace sales\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use sales\models\Order;
use sales\models\OrderPaid;
use sales\models\filters\OrderFilter;


/**
 * 客户中心订单筛选.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerOrderController extends Controller
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
                   'allow' => 'false',
                   'roles' => ['?'],
               ],
               [
                   'allow' => true,
               ],
           ],
        ];
    }



    /**
     * 所有订单
     */
    public function actionList()
    {

    }



    /**
     * 所有待付款订单.
     */
    public function actionPending()
    {

    }


    /**
     * 所有 processing 订单.
     */
    public function actionProcessing()
    {
        $filterModel = new OrderFilter([
            'status'      => Order::STATUS_PROCESSING,
            'customer_id' => $this->user->id,
        ]);
        $dataProvider = $filterModel->search($this->request->get());
        return $this->render('processing', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * 所有已发货订单
     * 
     */
    public function actionComplete()
    {

    }



    /**
     * 所有已收货订单
     */
    public function actionCompleteConfirm()
    {

    }




    /**
     * 交易关闭订单
     */
    public function actionClosed()
    {

    }




}