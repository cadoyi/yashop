<?php

namespace payment\frontend\controllers;

use Yii;
use yii\helpers\Url;
use frontend\controllers\Controller;
use payment\models\alipay\mobile\Pay;
use payment\models\alipay\mobile\PayReturn;
use payment\models\alipay\mobile\PayNotify;
use sales\models\OrderPaid as Order;

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
        $order =  Order::findOne([
            'increment_id' => $increment_id
        ]);
        
        if(!$order || ($order->customer_id != $this->user->id)) {
            return $this->notFound();
        }
        try {
            $pay = new Pay([
                'order'     => $order,
                'returnUrl' => Url::to(['return'], true),
                'notifyUrl' => Url::to(['notify'], true),
                'quitUrl'  =>  null,   //支付中途退出,应该返回到未支付订单页面
            ]);
            $html = $pay->toHtml();
            $response = Yii::$app->response;
            $response->clear();
            $response->data = $html;
            $response->send();                    
        } catch(\Exception $e) {
            throw $e;
        }
    }




    /**
     * 支付宝 return_url 地址, 支付成功才会调用这个页面.
     * 请求方法为 GET
     * 请求参数:
     *    charset: 
     *    out_trade_no
     *    method
     *    total_amount
     *    sign
     *    sign_type
     *    trade_no
     *    auth_app_id
     *    seller_id
     *    version
     *    timestamp
     *
     *  可以将返回的信息,通过 MQ 写入到 MongoDB 日志中.
     *    
     * @see  https://opendocs.alipay.com/open/203/107090
     * 
     * @return 重定向到 支付成功 的页面.
     */
    public function actionReturn()
    {
        $get = $this->request->get();

        // 记录日志
        // $this->log($get);
        
        $model = new PayReturn();
        $result = $model->verifyResponse($get);
        if(!$result) {
            return $this->notFound();
        }

        // 重定向到付款成功页面. 
        // 付款成功页面判断订单状态, 这时候就要调用查询接口来主动查询支付结果.
        $url = Url::to(['/checkout/quote/success'], true);
        return $this->redirect($url);
    }



    /**
     * 支付宝 notify_url 地址, 主要用于处理订单状态.
     * 请求方法: POST
     *
     * 请求参数:
     *    notify_id: 通知 ID
     *    notify_time: 通知时间 yyyy-MM-dd HH:mm:ss
     *    notify_type: 通知类型
     *    app_id: APP ID
     *    charset: utf-8
     *    version: 1.0
     *    sign:
     *    sign_type:
     *    trade_no: 支付宝交易凭证号码
     *    out_trade_no: 订单号
     *    out_biz_no: 可选
     *    buyer_id: 可选
     *    buyer_logon_id: 可选
     *    seller_id: 可选
     *    seller_email: 可选
     *    trade_status: 交易状态
     *    total_amount: 交易金额
     *    receipt_amount: 商家实际收款金额
     *    invoice_amount: 开票金额
     *    buyer_pay_amount: 付款金额
     *    point_amount: 集分宝金额
     *    refund_fee: 退款金额
     *    subject: 订单标题
     *    body: 商品描述
     *    gmt_create: 交易创建时间
     *    gmt_payment: 买家付款时间
     *    gmt_refund: 退款时间
     *    gmt_close: 交易结束时间
     *    fund_bill_list: 支付成功的各个渠道金额信息
     *    passback_params: 回传参数
     *    voucher_detail_list: 支付时使用的所有优惠券信息
     *    
     * 
     * 注意事项:
     *     接口要求幂等
     *     不能使用 session 和 cookie
     *     外网可访问
     *     不能使用重定向
     *     不能抛出异常
     *     同步通知(return_url)和异步通知(notify_url)先后顺序不定.
     *
     *  需要严格验证如下内容:
     *     1. out_trade_no 是否存在,对应的订单是否存在.
     *     2. total_amount 是否为订单的实际金额
     *     3. 验证 seller_id 
     *     4. 验证 app_id
     *     任何一个步骤验证出错,则都不要处理订单,因为这表示这个通知是异常通知.
     *     
     *  交易状态:
     *     TRADE_SUCCESS: 签约的产品支持退款, 并且已经付款成功.
     *     TRADE_FINISHED: 如下两种情况会变成这个状态.
     *         1.支持退款:   交易已经成功,并且过了退款期限.
     *         2.不支持退款: 付款成功.
     *     WAIT_BUYER_PAY:  交易已经创建, 正等待买家付款.
     *     TRADE_CLOSED: 未付款造成交易超时而关闭 或者 支付完成后又进行了全额退款.
     *
     * @return string    success | error
     *     返回:
     *         成功: success
     *     如果不返回 success, 或者返回去其他, 则支付宝还会再次通知.
     *     重试间隔: 
     *         4m,10m,10m,1h,2h,6h,15h  最多通知 24 小时 22 分钟.
     *     重试过程中, notify_id 是不变的.
     */    
    public function actionNotify()
    {

        // 记录日志
        // $this->log($this->request->post());
        
        try {
            $model = new PayNotify();
            $model->verifyResponse($this->request->post());            
            $model->saveOrder();
            $model->success();
        } catch(\Throwable $e) {
            $model->error();
        }
        
    }



}