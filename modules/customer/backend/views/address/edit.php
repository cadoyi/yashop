<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $customer customer\models\Customer
 * @var  $address customer\models\CustomerAddress
 * 
 */
$this->title = Yii::t('app', 'Edit address');
$this->addBreadcrumb(Yii::t('app', 'Manage customers'), ['/customer/customer/index']);
$this->addBreadcrumb(Yii::t('app', 'Address list'), ['index', 'cid' => $customer->id]);

?>
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
        'class' => 'btn btn-sm btn-molv',
    ]) ?>

<?php $this->endForm() ?>

