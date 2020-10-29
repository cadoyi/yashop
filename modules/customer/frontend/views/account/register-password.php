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
$this->title = Yii::t('app', 'Register') . ' 填写密码';
?>
<?php $this->beginBlock('header') ?>
    <ul class="nav mr-auto header-left">
        <li class="nav-item">
            <a class="nav-link" 
               href="<?= Url::to(['/customer/account/register'])?>">
                用户注册
            </a>
        </li>
    </ul>
    <ul class="nav header-right">
        <li class="nav-item">
            <a class="nav-link" href="<?= Url::to(['/customer/account/login'])?>">登录</a>
        </li>
    </ul>
<?php $this->endBlock(); ?>
<div class="register register-password">
    <?php $form = $this->beginForm([
            'id' => 'customer_register_form',
            'options' => [
                'class' => 'register-form',
             ],
    ]) ?>
        <div class="form-group ">
            <h1 class="h5">新用户注册</h1>
        </div>
        <?= $form->field($model, 'username')->textInput([
            'placeholder' => Yii::t('app', 'Phone number or email address'),
            'disabled' => 'disabled',
            'class' => 'form-control username-input'
        ]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_confirm')->passwordInput() ?>
        <div class="form-group row">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-10">
                <?= Html::submitButton('完成注册', [
                    'id'    => 'submit_button',
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
        </div>
    <?php $this->endForm() ?>
</div>

