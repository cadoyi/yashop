<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $customer backend\models\customer\Customer
 * @var  $model backend\models\customer\forms\CustomerPasswordForm;
 * 
 */
?>
<?php $this->beginBlock('content') ?>
<div class="mw-500">
    <?php $form = ActiveForm::begin([
        'id' => 'customer_password_form',
    ]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_confirm')->passwordInput() ?>
        <?= Html::submitButton(Yii::t('app', 'Save'), [
            'class' => 'btn btn-sm btn-primary',
        ]) ?>
    <?php ActiveForm::end() ?>
</div>
<?php $this->endBlock() ?>
<?php $this->beginContent('@customer/backend/views/customer/_update.php', [
    'key' => $customer->id,
    'itemName' => 'password',
]) ?>

<?php $this->endContent() ?>
