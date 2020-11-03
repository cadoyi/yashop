<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model backend\models\customer\account\CustomerPhone
 * 
 */
$this->title = Yii::t('app', 'Add customer phone');

$this->addBreadcrumb(Yii::t('app', 'Manage customers'), ['index']);
$this->addBreadcrumb(Yii::t('app', 'Edit customer'), ['update-account', 'id' => $model->customer_id]);
?>
<?php $form = $this->beginForm([
    'id' => 'add_customer_phone_form',
]) ?>
    <?= $form->field($model, 'username') ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
         'class' => 'btn btn-sm btn-molv',
    ]) ?>
<?php $this->endForm() ?>