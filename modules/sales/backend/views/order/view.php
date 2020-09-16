<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\basic\sales\OrderAsset;
OrderAsset::register($this);
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $order sales\models\Order
 *
 * 
 */
$this->title = Yii::t('app', 'View {name}', ['name' => Yii::t('app', 'Order')]) . ' #' . $order->increment_id;
$this->addBreadcrumb(Yii::t('app', 'Manage orders'), ['index']);
?>
<div class="d-flex border-bottom py-2 px-3">
    <div class="flex-grow-1">
        <div>订单号: #<?= $order->increment_id ?> | <?= $order->asDatetime('created_at') ?></div>
    </div>
    <div class="">
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-sm btn-outline-secondary'])?>
        <?= Html::a('发货', '#', ['class' => 'btn btn-sm btn-primary']) ?>
    </div>
</div>
<div class="order-info row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">订单信息: #<?= $order->increment_id ?></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>订单日期</th>
                        <td><?= $order->asDatetime('created_at') ?></td>
                    </tr>
                    <tr>
                        <th>订单状态</th>
                        <td><?= Html::encode($order->statusText) ?></td>
                    </tr>
                    <tr>
                        <th>下单 IP</th>
                        <td>暂无内容</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-header">
                客户信息
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>客户昵称</th>
                        <td><?= Html::encode($order->customer_nickname) ?></td>
                    </tr>
                    <tr>
                        <th>邮件地址</th>
                        <td><?= Html::encode($order->customer_email) ?></td>
                    </tr>
                    <tr>
                        <th>手机号码</th>
                        <td><?= Html::encode($order->customer_phone) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


        <div class="col-6">
            <?php if(!$order->is_virtual): ?>
                <?php $address = $order->address; ?>            
                <div class="card">
                    <div class="card-header">
                        送货地址
                    </div>
                    <div class="card-body p-3">
                        <div>
                            <?= Html::encode($address->name) ?> <?= Html::encode($address->phone) ?>
                        </div>
                        <div>
                            <?= Html::encode($address->region) ?>
                            <?= Html::encode($address->city) ?>
                            <?= Html::encode($address->area) ?>
                        </div>
                        <div>
                            <?= Html::encode($address->street) ?>
                        </div>
                    </div>
                </div>    
            <?php endif; ?>
        </div>

    <div class="col-6">
        <div class="card">
            <div class="card-header">支付信息</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>支付方法</th>
                        <td><?= Html::encode($order->orderPaid->method) ?></td>
                    </tr>
                    <tr>
                        <th>支付金额</th>
                        <td>
                            <?= Html::encode($order->orderPaid->grand_total)?>
                            <?php if(!$order->isPaided()): ?>
                            (未支付)
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                购买的产品
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>图片</th>
                            <th>产品名</th>
                            <th>属性</th>
                            <th>单价</th>
                            <th>数量</th>
                            <th>总价</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($order->items as $item): ?>
                            <?php $product = $item->orderProduct; ?>
                            <tr>
                                <td>
                                    <img 
                                        alt="<?= Html::encode($product->name)?>"
                                        src="<?= $product->getImageUrl(90) ?>"
                                    />
                                </td>
                                <td>
                                    <?= Html::encode($product->name) ?>
                                </td>
                                <td>
                                    <ul class="list-unstyled">
                                    <?php foreach($product->attrs as $name => $value): ?>
                                        <li>
                                            <?= Html::encode($name) ?> : 
                                            <?= Html::encode($value) ?>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <?= Html::encode($product->price) ?>
                                </td>
                                <td>
                                    <?= Html::encode($product->qty) ?>
                                </td>
                                <td>
                                    <?= Html::encode($product->rowTotal) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                订单历史状态
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <?php foreach($order->statusHistories as $history): ?>
                        <tr>
                            <td><?= $history->asDatetime('created_at') ?></td>
                            <td><?= Html::encode($history->statusText) ?></td>
                            <td><?= Html::encode($history->comment) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>