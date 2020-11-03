<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;
use frontend\assets\basic\customer\AccountAsset;
AccountAsset::register($this);

?>
<?php 
/**
 * @var  $this yii\web\View
 *
 * 
 */
$this->title = Yii::t('app', 'Register') . ' 填写帐号';
?>
<?php $this->beginBlock('header') ?>
    <ul class="nav mr-auto header-left">
        <li class="nav-item">
            <a class="nav-link" 
               href="<?= Url::to(['/customer/account/forgot-password'])?>">
                找回密码
            </a>
        </li>
    </ul>
    <ul class="nav header-right">
        <li class="nav-item">
            <a class="nav-link" href="<?= Url::to(['/customer/account/login'])?>">登录</a>
        </li>
    </ul>
<?php $this->endBlock(); ?>
<div class="forgot-password">
    <?php $form = $this->beginForm([
            'id' => 'customer_forgot_password_form',
            'options' => [
                'class' => 'forgot-password-form',
             ],
    ]) ?>
        <div class="form-group pb-3">
            <h1 class="h5">您正在找回您的密码</h1>
        </div>
        <?= $form->field($model, 'username')->textInput([
            'placeholder' => Yii::t('app', 'Phone number or email address'),
        ]) ?>
        <?= $form->field($model, 'code')->widget(Captcha::class, [
               'captchaAction' => ['/customer/account/captcha'],
               'template' => '<div class="d-flex flex-nowrap">{input} {image}</div>',
               'options' => [
                   'class' => 'form-control',
                   'placeholder' => '请输入验证码',
               ],
        ]) ?>
        <div class="form-group row">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-10">
                <?= Html::submitButton('下一步', [
                    'id'    => 'submit_button',
                    'class' => 'btn btn-sm btn-molv btn-very-long',
                ]) ?>
                
            </div>
        </div>
    <?php $this->endForm() ?>
</div>