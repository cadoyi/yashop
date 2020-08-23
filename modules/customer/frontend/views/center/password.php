<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model customer\frontend\models\center\PasswordForm
 * 
 */
$this->title = Yii::t('app', 'Change password')
?>
<div class="customer-center-password py-5 px-3">
<?php $form = $this->beginForm([
    'id' => 'customer_center_change_password_form',
]) ?>
   <?= $form->field($model, 'original_password')->passwordInput() ?>
   <?= $form->field($model, 'password')->passwordInput() ?>
   <?= $form->field($model, 'password_confirm')->passwordInput() ?>

   <?= Html::submitButton(Yii::t('app', 'Save'), [
       'class' => 'btn btn-sm btn-primary',
   ]) ?>
<?php $this->endForm() ?>
</div>