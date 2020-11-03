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
<div class="forgot-password forgot-password-verify">
    <?php $form = $this->beginForm([
            'id' => 'customer_forgot_password_form',
            'options' => [
                'class' => 'forgot-password-form',
             ],
    ]) ?>
        <div class="form-group pb-3">
            <h1 class="h5">请验证您的用户名</h1>
        </div>
        <?= $form->field($model, 'username')->textInput([
            'class' => 'form-control username-input',
        ]) ?>
        <?= $form->field($model, 'password')
            ->passwordInput()
            ->label('新密码') 
        ?>
        <?= $form->field($model, 'password_confirm')
            ->passwordInput()
            ->label('确认密码') 
        ?>

        <div class="form-group row">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-10">
                <?= Html::submitButton('重置密码', [
                    'id'    => 'submit_button',
                    'class' => 'btn btn-sm btn-molv btn-very-long',
                ]) ?>
            </div>
        </div>
    <?php $this->endForm() ?>
</div>