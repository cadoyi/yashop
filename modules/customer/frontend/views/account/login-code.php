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
                    </div>{input}</div><div><button id="sendcode" class="btn btn-submit text-nowrap rounded-0">发送验证码</button></div></div>{error}'
                ])->textInput([
                    'placeholder' => '验证码',
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
<?php $this->beginScript() ?>
<script>
    $('#sendcode').on('click', function( e ) {
        stopEvent(e);
        var self = $(this);
        var input = $('#logincodeform-username');
        var username = input.val();
        if(!username) {
            op.alert('请输入用户名').then(function() {
                input.focus();
            });
            return;
        }
        self.attr('disabled', 'disabled').text('发送中...');
        var url = '<?= Url::to(['/customer/account/send-login-code']) ?>';
        $.post(url, {username: username}).then(function( res ) {
            if(res.error) {
                if(res.error === 2) {
                    $.each(res.data, function(k,m) {
                        op.alert(m);
                        self.removeAttr('disabled').text('发送验证码');
                        return false;
                    });
                    self.removeAttr('disabled').text('发送验证码');
                    return;
                }
                self.removeAttr('disabled').text('发送验证码');
                op.alert(res.message);
                return;
            }
            op.msg('验证码已发送');
            downtime(60, function(t) {
                self.attr('disabled', 'disabled').text('重新发送（' + t +'）');
                if(t == 0) {
                    self.removeAttr('disabled').text('发送验证码');
                }
            });
        });

    });
</script>
<?php $this->endScript() ?>
