<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
?>
<?php 
/**
 * @var  $this yii\web\View
 *
 * 
 */
$this->title = Yii::t('app', 'Register');
?>
<div class="register-container d-flex flex-nowrap">

    <div class="ml-auto my-5" style="width: 300px;">
        <div class="text-center">
            <h1><?= Yii::t('app', 'Welcome to register') ?></h1>
        </div>
        <?php $form = $this->beginForm([
            'id' => 'customer_register_form',
            'layout' => 'default',
        ]) ?>
        <?= $form->field($model, 'username')->textInput([
            'placeholder' => Yii::t('app', 'Phone number or email address'),
        ]) ?>
        <div class="d-flex flex-nowrap">
            <?= $form->field($model, 'code')->textInput([
                'placeholder' => Yii::t('app', 'Please input verify code'),
            ]) ?>
            <div class="form-group">
                <label class="w-100" for="send_code">&nbsp;</label>
                <button id="send_code" 
                        type="button" 
                        class="btn btn-outline-secondary rounded-0 text-nowrap">
                    <?= Yii::t('app', 'Send verify code') ?>
                </button>
            </div>
        </div>
        <?= $form->field($model, 'password')->passwordInput([
             'placeholder' => Yii::t('app', 'Please input password'),
        ]) ?>
        <?= $form->field($model, 'password_confirm')->passwordInput([
             'placeholder' => Yii::t('app', 'Please input confirm password'),
        ]) ?>
        <?= Html::submitButton(Yii::t('app', 'Register'), [
            'class' => 'btn btn-block btn-primary rounded-0',
        ]); ?>
        <?php $this->endForm() ?>
        <div class="form-group py-2">
            <input id="i_agree" type="checkbox" checked> 
            <?= Yii::t('app', 'I agree') ?> 
            <a href="#">用户协议</a>
        </div>
    </div>
    <div class="my-5" style="width:300px;">
        <div class="py-3">
            <?= Yii::t('app', 'Already have account')?> ? 
            <a class="d-inline" 
               href="<?= Url::to(['/customer/account/login'])?>"
            ><?= Yii::t('app', 'Quick to login') ?>&gt;&gt;</a>
        </div>
    </div>
</div>