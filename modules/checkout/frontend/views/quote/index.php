<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\checkout\QuoteAsset;
QuoteAsset::register($this);
?>
<?php 
/**
 * @var  $this yii\web\View
 * 
 */
$customer = Yii::$app->user->identity;
$addresses = $customer->addresses;
$this->title = Yii::t('app', 'Checkout quote');
?>
<div class="quote-submitter">
    <?= Html::beginForm(['/sales/order/submit'], 'post') ?>
    <input type="hidden" name="quote_id" value="<?= $quote->id ?>" />
    <?php if($quote->hasRealProduct()): ?>
        <div class="px-3"><h5 class="mb-0">选择地址</h5></div>
        <div id="address_bar" class="address-bar d-flex overflow-auto p-3">
            <?php foreach($addresses as $address): ?>
            <div class="card m-1 address-card" style="width: 320px;min-width: 320px; max-width: 320px;">
                <div class="card-header d-flex flex-nowrap justify-content-arround">
                    <div class="mr-2">
                        <input id="address_id_<?= $address->id ?>" class="d-none address-input" type="radio" name="address_id" value="<?= $address->id ?>" />
                        <label class="address-label" for="address_id_<?= $address->id ?>"></label>
                    </div>
                    <div class="tag tag-primary mr-auto">
                        <?= Html::encode( $address->tag ) ?>
                    </div>
                    <div class="d-flex flex-nowrap">
                        <?php if($address->isDefault()): ?>
                            <div class="default-address mr-2">默认地址</div>
                        <?php endif; ?>
                        <a href="<?= Url::to(['/customer/address/update', 'cid' => $customer->id, 'id' => $address->id ]) ?>">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="namephone">
                        <?= Html::encode($address->name ) ?>
                        <?= Html::encode($address->phone ) ?>
                    </div>
                    <div class="">
                        <?= Html::encode($address->region . $address->city . $address->area )?>
                        <?= Html::encode($address->street) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <div class=" p-5">
                <a class="add-address btn btn-outline-danger rounded-0" href="#">
                     <div>+ 添加地址</div>
                </a>
            </div>
        </div>
    <?php endif; ?>
    <div class="quote-item px-3">
        <table class="table table-hover table-bordered quote-item-table">
            <thead>
                <th>图片</th>
                <th>产品名</th>
                <th>产品选项</th>
                <th>产品数量</th>
                <th>产品价格</th>
            </thead>
            <tbody>
                <?php foreach($quote->items as $item): ?>
                    <?php $product = $item->product; ?>
                    <?php $productSku = $item->productSku ?>
                    <tr>
                        <td>
                            <a href="<?= Url::to(['/catalog/product/view', 'id' => $product->id ])?>">
                                <?php if($productSku): ?>
                                <img src="<?= $productSku->getImageUrl(200)?>" />
                                <?php else: ?>
                                    <img src="<?= $product->getImageUrl(200)?>" />
                                <?php endif; ?>
                            </a>
                        </td>
                        <td>
                            <?= Html::encode($product->name) ?>
                        </td>
                        <td>

                            <?php if($productSku): ?>
                                <ul class="list-unstyled">
                                    <?php foreach($productSku->attrs as $attrName => $attrValue ): ?>
                                        <li>
                                            <span><?= Html::encode($attrName) ?>: </span>
                                            <span><?= Html::encode($attrValue) ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>    
                            <?php else: ?>
                                &nbsp;
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= Html::encode($item->qty) ?>
                        </td>
                        <td>
                            &yen; <?= Html::encode($item->getGrandTotal()) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="form-group payment-selector p-3">
        <table class="table table-hover table-bordered">
            <caption>选择支付方式</caption>
            <thead>
                <tr>
                    <th>选择支付方式</th>
                    <th>支付方式描述</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <label>
                            <input type="radio" name="payment_method" value="alipay" />
                            支付宝
                        </label>
                    </td>
                    <td>支付宝</td>
                </tr>
                <tr>
                    <td>
                        <label>
                            <input type="radio" name="payment_method" value="wxpay" />
                            微信
                        </label>
                    </td>
                    <td>微信</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-group d-flex align-items-center justify-content-end p-3">
        <div class="mr-3">
            <span>共 <?= $quote->product_count ?> 类 <?= $quote->qty?> 件产品, 合计 &yen; <?= $quote->grand_total ?></span>
        </div>
        <div>
            <?= Html::submitButton('提交订单', [
                'class' => 'btn btn-sm btn-primary',
                'id'    => 'submit_order',
            ]) ?>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>