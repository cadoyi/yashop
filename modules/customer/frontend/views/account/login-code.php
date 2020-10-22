<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
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
$this->title = Yii::t('app', 'Login');
?>
<style>
    main.content {
        background-image: url('/skin/basic/img/phs/account-layout-bg.jpg');
        background-repeat: none;
        background-size: 100% 100%;
    }
</style>
<div class="login login-code d-flex justify-content-end">
    <div class="bg-white wrapper">
        <ul class="nav nav-tabs">
            <li class="nav-item col">
                <a class="nav-link" 
                   href="<?= Url::to(['/customer/account/login'])?>">密码登录</a>
            </li>
            <li class="nav-item col">
                <a  class="nav-link active"
                    data-toggle="tab"
                    href="#login_code">验证码登录</a>
            </li>
        </ul>

        <div class="tab-content pt-3">
            <div id="login_code"
                 class="tab-pane fade show active"
            >
                <?php $form = $this->beginForm([
                    'id' => 'login_form',
                    'layout' => 'default',
                ]) ?>
                <?= $form->field($model, 'username', [
                    'template' => '<div class="input-group">
                    <div class="input-group-prepend">
                          <span class="input-group-text">
                           <i class="fa fa-user"></i>
                          </span>
                    </div>{input}</div>{error}'
                ])->textInput([
                   'placeholder' => '邮件地址或手机号码',
                ])->label('') ?>

                <?= $form->field($model, 'code',[
                    'template' => '<div class="d-flex flex-nowrap">
                    <div class="input-group">
                    <div class="input-group-prepend">
                          <span class="input-group-text">
                              <i class="fa fa-envelope-open"></i>
                          </span>
                    </div>{input}</div><div><button class="btn btn-submit text-nowrap rounded-0">发送验证码</button></div></div>{error}'
                ])->passwordInput([
                    'placeholder' => '请输入密码',
                ])->label('') ?>

                <div class="form-group">
                    <?= Html::submitButton('登录', [
                        'class' => 'btn btn-block btn-submit rounded-0'
                    ]) ?>
                </div>
                <?php $this->endForm() ?>
                <div class="form-group wechat-login">
                    <a href="<?= Url::to(['/customer/weixin/login']) ?>">
                        <i class="fa fa-weixin"></i> 微信登录
                    </a>
                </div>
                <div class="form-group d-flex justify-content-end actions">
                    <a href="<?= Url::to(['/customer/account/register']) ?>">
                        立即注册
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
