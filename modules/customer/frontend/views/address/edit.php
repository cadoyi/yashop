<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $customer customer\models\Customer
 * @var  $address customer\models\CustomerAddress
 * 
 */
$this->title = Yii::t('app', 'Edit address');
?>
<?php $this->beginBlock('menus'); ?>
     <?= Html::a(Yii::t('app', 'Address list'), ['index']) ?> / <?= $this->title ?>
<?php $this->endBlock('menus') ?>
<div class="px-3 py-5" style="max-width: 500px;">
<?php $form = $this->beginForm([
    'id' => 'edit_customer_address_form',
]) ?>
    <?= $form->field($address, 'tag') ?>
    <?= $form->field($address, 'name') ?>
    <?= $form->field($address, 'phone') ?>
    <?= $form->field($address, 'region') ?>
    <?= $form->field($address, 'city') ?>
    <?= $form->field($address, 'area') ?>
    <?= $form->field($address, 'street')->textarea() ?>
    <?= $form->field($address, 'zipcode') ?>
    <?= $form->field($address, 'as_default')->checkbox([
        'checked' => $address->isDefault(),
    ]) ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-primary',
    ]) ?>
<?php $this->endForm() ?>
</div>

