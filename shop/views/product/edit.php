<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Nav;
use shop\assets\basic\ProductAsset;
ProductAsset::register($this);
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $model catalog\models\forms\ProductEditForm
 * 
 */
$product = $model->product;

$this->title = '新增宝贝';
$this->addBreadcrumb('产品列表', ['index']);
?>
<div class="product-edit">
    <?= Nav::widget([
        'options' => [
             'class' => 'nav nav-tabs nav-tabs-brief',
        ], 
        'items' => [
            [
                'label' => '基本信息',
                'url'  => '#base_info',
                'active' => true,
                'linkOptions' => [
                    'data-toggle' => 'tab',
                ],
            ],
            [
                'label' => '价格信息',
                'url'  => '#price_info',
                'active' => false,
                'linkOptions' => [
                    'data-toggle' => 'tab',
                ],
            ],
            [
                'label' => '产品规格',
                'url'  => '#product_type',
                'active' => false,
                'linkOptions' => [
                    'data-toggle' => 'tab',
                ],
            ],
            [
                'label' => '库存信息',
                'url'  => '#stock_info',
                'active' => false,
                'linkOptions' => [
                    'data-toggle' => 'tab',
                ],
            ],
            [
                'label' => '产品描述',
                'url'  => '#product_description',
                'active' => false,
                'linkOptions' => [
                    'data-toggle' => 'tab',
                ],
            ],
            [
                'label' => '产品画册',
                'url'  => '#gallery_info',
                'active' => false,
                'linkOptions' => [
                    'data-toggle' => 'tab',
                ],
            ],
            [
                'label' => '产品选项',
                'url'  => '#product_options',
                'active' => false,
                'linkOptions' => [
                    'data-toggle' => 'tab',
                ],
            ],
            [
                'label' => '产品 SKU',
                'url'  => '#product_skus',
                'active' => false,
                'linkOptions' => [
                    'data-toggle' => 'tab',
                ],
                'disabled' => $product->isNewRecord,
            ],
        ],
    ])?>
<?php $form = $this->beginForm([
    'id' => 'product_edit_form',
]) ?>
<?php 
/**
 * @var  $renderOptions 渲染子页面的选项.
 */
$renderOptions = [
    'model'   => $model,
    'product' => $product,
    'form'    => $form,
];
?>
    <div class="tab-content py-3">
        <div id="base_info" class="tab-pane fade  show active">
            <?= $this->render('edit/base', $renderOptions) ?>
        </div>
        <div id="price_info" class="tab-pane fade" >
            <?= $this->render('edit/price', $renderOptions) ?>
        </div>
        <div id="product_type" class="tab-pane fade">
            <?= $this->render('edit/product_type', $renderOptions) ?>
        </div>
        <div id="stock_info" class="tab-pane fade">
            <?= $this->render('edit/stock', $renderOptions) ?>
        </div>
        <div id="product_description" class="tab-pane fade">
            <?= $this->render('edit/description', $renderOptions) ?>
        </div>
        <div id="gallery_info" class="tab-pane fade">
            <?= $this->render('edit/gallery', $renderOptions) ?>
        </div>
        <div id="product_options" class="tab-pane fade">
            <?= $this->render('edit/options', $renderOptions) ?>
        </div>
        <?php if(!$product->isNewRecord): ?>
            <div id="product_skus" class="tab-pane fade">
                <?= $this->render('edit/skus', $renderOptions) ?>
            </div>
        <?php endif; ?>
    </div>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
           'class' => 'btn btn-sm btn-molv',
    ])?>
<?php $this->endForm() ?>
</div>
