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
<div class="register">
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
                <div class="agreement mb-2">
                    <input id="agreeinput" 
                           class="checkbox" 
                           type="checkbox" 
                           checked 
                    />
                    <label for="agreeinput">我同意 <a href="#">&lt;&lt;用户协议&gt;&gt;</a></label>
                </div>
                <?= Html::submitButton('下一步', [
                    'id'    => 'submit_button',
                    'class' => 'btn btn-primary',
                ]) ?>
                
            </div>
        </div>
    <?php $this->endForm() ?>
</div>
<?php $this->beginScript() ?>
<script>
    $('#agreeinput').on('change', function( e ) {
        var self = $(this);
        if(!self.prop('checked')) {
            $('#submit_button')
                .attr('disabled', 'disabled');
        } else {
            $('#submit_button').removeAttr('disabled');
        }
    });
</script>
<?php $this->endScript() ?>
