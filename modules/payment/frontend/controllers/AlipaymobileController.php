<?php

namespace payment\frontend\controllers;

use Yii;
use yii\helpers\Url;
use frontend\controllers\Controller;
use payment\models\alipaymobile\Pay;
use payment\models\alipaymobile\PayReturn;

/**
 * 支付宝手机网页支付
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AlipaymobileController extends Controller
{


    /**
     * @inheritdoc
     */
    public function access()
    {
        return [
           'only' => ['pay'],
           'rules' => [
               [
                   'allow' => false,
                   'roles' => ['?'],
               ],
               [
                    'allow' => true,
               ],
           ],
        ];
    }


    /**
     * 跳转到支付宝手机支付页面.
     * 
     * @return string  支付宝返回的 form 表单, form 表单会自动提交.
     */
    public function actionPay()
    {
        // 订单 ID 存储在 session 中.
        $increment_id = $this->session->get('last_order_increment_id', false);
        if(!$increment_id) {
            return $this->notFound();
        }
        $order =  Order::findByIncrementId($increment_id);
        if(!$order || ($order->customer_id != $this->user->id)) {
            return $this->notFound();
        }
        $pay = new Pay([
            'order'     => $order,
            'returnUrl' => Url::to(['return'], true),
            'notifyUrl' => Url::to(['notify'], true),
        ]);
        $html = $pay->toHtml();
        $response = Yii::$app->response;
        $response->clear();
        $response->data = $html;
        $response->send();
    }




    /**
     * 支付宝 return_url 地址
     * 
     * @return 重定向到 支付成功/支付失败 的页面.
     */
    public function actionReturn()
    {

    }



    /**
     * 支付宝 notify_url 地址
     * 
     * @return string    success | error
     */
    public function actionNotify()
    {

    }



}