<?php
use yii\helpers\Html;
use yii\helpers\Url;
use cando\storage\widgets\Uploader;
?>
<?php 
/**
 * 编辑 sku
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
?>
<?php $form = $this->beginForm([
     'id' => 'edit_product_sku_form',
     'enableAjaxValidation' => true,
]) ?>
    <?= $form->field($model, 'image')->widget(Uploader::class, [
        'uploadUrl' => ['/file/upload', 'id' => 'catalog/product/images'],
        //'url' => $model->getImageUrl(),
    ]) ?>
    <?php foreach($model->getOptions() as $option): ?>
        <?= $form->field($model, $option->name)->dropDownList($model->getOptionHashOptions($option), ['prompt' => '']) ?>
    <?php endforeach; ?>
    <?= $form->field($model, 'qty') ?>
    <?= $form->field($model, 'price') ?>
    <?= $form->field($model, 'promote_price') ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-primary',
    ]) ?>
<?php $this->endForm() ?>