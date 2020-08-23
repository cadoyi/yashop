<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * 
 * @var  $this yii\web\View
 * @var  $model customer\frontend\models\account\PasswordForm
 * 
 */
$this->title = Yii::t('app', 'Reset password');
$this->addBreadcrumb(Yii::t('app', 'Forgot password'), ['forgot-password']);
?>
<style>
    label {white-space: nowrap;}
</style>
<div class="d-flex justify-content-center p-3">
    <div style="width: 350px">
        <?php $form = $this->beginForm() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'password_confirm')->passwordInput() ?>
            <?= Html::submitButton(Yii::t('app', 'Save'), [
                'class' => 'btn btn-sm btn-primary',
            ])?>
        <?php $this->endForm(); ?>
    </div>
</div>