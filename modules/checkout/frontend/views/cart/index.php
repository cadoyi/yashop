<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use frontend\assets\basic\checkout\CartAsset;
CartAsset::register($this);
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $cart checkout\models\Cart
 * @var  $filterModel checkout\models\filters\CartItemFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 *
 */
$this->registerJsVar('qtyLink', Url::to(['/checkout/cart/update-item-qty']));


$this->title = Yii::t('app', 'Shopping cart');
?>
<style>
    .table td,
    .table th { vertical-align: middle; text-align: center; }
</style>
<div id="cart_items" class="cart-items p-3">
    <div class="grid-buttons p-2 text-right">
        <a class="btn btn-sm btn-warning" 
           href="<?= Url::to(['/checkout/cart/empty']) ?>"
           data-method="post"
           data-confirm="<?= Yii::t('app', 'Do you want empty shopping cart')?>"
        >
           清空购物车
       </a>
    </div>
    <?= GridView::widget([
        'id' => 'checkout_cart_grid',
        //'filterModel' => $filterModel,
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => CheckboxColumn::class,
                'checkboxOptions' => [
                    'class' => 'checkout-it',
                ],
            ],
            'product_id' => [
                'attribute' => 'product_id',
                'filter' => false,
                'format' => 'raw',
                'header' => '产品名',
                'value' => function($model, $key, $index, $column) {
                    $product = $model->product;
                    $skuModel = $model->getSkuModel();
                    if(!$skuModel) {
                        return '已失效';
                    }
                    $url = $skuModel->getImageUrl(90);
                    return Html::a(Html::img($url), ['/catalog/product/view', 'id' => (string) $product->id ]) . '<div>' . Html::encode($product->name) .'</div>';
                }
            ],
            'product_sku' => [
                'attribute' => 'product_sku',
                'filter' => false,
                'format' => 'raw',
                'header' => '规格',
                'value' => function($model, $key, $index, $column) {
                    $skuModel = $model->getSkuModel();
                    if(!$skuModel) {
                        return '已失效';
                    }
                    return $skuModel->sku;
                }
            ],
            'qty' => [
                'attribute' => 'qty',
                'header'    => '数量',
                'format'    => 'raw',
                'value'     => function($model, $key, $index, $column) {
                    $skuModel = $model->skuModel;
                    return Html::input('number', 'qty', $model->qty, [
                       'class'        => 'qty-input',
                       'origin-value' => $model->qty,
                       'item-id'      => $key,
                       'min'          => 1,
                       'max'          => isset($skuModel) ? $skuModel->stock : 1,
                    ]);
                }
            ],
            'price' => [
                'attribute' => 'qty',
                'header'    => '价格',
                'format'    => 'raw',
                'value' => function($model, $key, $index, $column) {
                    $content = $model->getPrice();
                    if(is_null($content)) {
                        $content = '已失效';
                    } else {
                        $content = '￥' . $content;
                    }
                    return Html::tag('div', $content, ['class' => 'price']);
                }
            ],
            [
                'class' => ActionColumn::class,
                'header' => '操作',
                'template' => '{delete}',
                'buttons' => [
                     'delete' => function( $action, $model, $key ) {
                         return Html::a('删除', [
                               '/checkout/cart/remove-item', 
                               'id' => $key
                            ], [
                               'class' => 'text-danger',
                               'data-confirm' => Yii::t('app', 'Do you want remove it?'),
                               'data-method' => 'post',
                            ]);
                     }
                ],
            ],
        ],
    ]) ?>

    <div class="p-3 d-flex flex-nowrap justify-content-between">
        <a class="btn btn-sm btn-outline-primary"
           href="<?= Yii::$app->controller->getReferrerUrl() ?>"
        >
           <i class="fa fa-arrow-left"></i>
            再逛逛
        </a>
        <div class="flex-grow-1 text-right">
            <div class="d-inline-block checkout-price-total mr-3">
                合计 &yen; <span id="checkout_show_total">0.00</span>
            </div>
            <button id="checkout_button"  
                checkout-button
                disabled="disabled"
                class="btn btn-sm btn-danger"
            >
                去结算
                <i class="fa fa-arrow-right"></i>
            </button>
       </div>
    </div>
    <?= Html::beginForm(['/checkout/quote/add'], 'post', [
        'class' => 'd-none',
        'id' => 'checkout_form',
    ]) ?>
        <select id="cart_select_input" name="carts[]" multiple="multiple">
        </select>
    <?= Html::endForm() ?>
</div>
