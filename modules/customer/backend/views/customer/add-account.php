<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model customer\backend\models\customer\AddAccount
 * 
 */
$this->title = Yii::t('app', 'Add {type} account', ['type' => $model->type ]);

$this->addBreadcrumb(Yii::t('app', 'Manage customers'), ['index']);
$this->addBreadcrumb(Yii::t('app', 'Edit customer'), ['account', 'id' => $customer->id]);
?>
<?php $form = ActiveForm::begin([
    'id' => 'add_customer_email_form',
]) ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password_confirm')->passwordInput() ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
         'class' => 'btn btn-sm btn-primary',
    ]) ?>
<?php ActiveForm::end() ?>