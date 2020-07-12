<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model backend\models\customer\account\CustomerPhone
 * 
 */
$this->title = Yii::t('app', 'Add customer email');

$this->addBreadcrumb(Yii::t('app', 'Manage customers'), ['index']);
$this->addBreadcrumb(Yii::t('app', 'Edit customer'), ['update-account', 'id' => $model->customer_id]);
?>
<?php $form = ActiveForm::begin([
    'id' => 'add_customer_email_form',
]) ?>
    <?= $form->field($model, 'username') ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
         'class' => 'btn btn-sm btn-primary',
    ]) ?>
<?php ActiveForm::end() ?>