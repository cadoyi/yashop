<?php
use yii\helpers\Html;
use yii\helpers\Url;
use core\widgets\Uploader;
?>
<?php 
/**
 * 
 * @var  $this yii\web\View
 * @var  $product catalog\models\Product
 * @var  $model catalog\backend\models\ProductSkuForm
 * 
 */
$this->title = '编辑 SKU';
$this->addBreadcrumb('管理 SKU', ['index', 'pid' => $product->id ]);
?>
<div class="p-3">
<?php $form = $this->beginForm(['id' => 'product_sku_form']) ?>
    <?= $form->field($model, 'image')->widget(Uploader::class, [
        'uploadId' => 'catalog/product/images',
    ]) ?>
    <?php foreach($model->getOptions() as $option): ?>
        <?= $form->field($model, $option->name)
            ->dropDownList($model->getOptionHashOptions($option), ['prompt' => '']) ?>
    <?php endforeach; ?>
    <?= $form->field($model, 'qty') ?>
    <?= $form->field($model, 'price') ?>
    <?= $form->field($model, 'promote_price') ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-primary',
    ]) ?>
<?php $this->endForm() ?>
</div>