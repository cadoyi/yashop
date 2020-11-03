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
        <?= $form->field($model, 'code', [
           'template' => '<div class="d-flex flex-nowrap w-100">
                    {label}
                    <div class="col-sm-10">
                        <div class="d-flex flex-nowrap">
                            {input}
                            <div>
                                <button id="sendcode" 
                                    class="sendcode btn btn-outline-secondary text-nowrap"
                                >
                                    发送验证码
                                </button>
                            </div>
                        </div>
                        {error}            
                    </div>
                </div>'
        ])->textInput([
            'placeholder' => '输入获取的验证码',
        ]) ?>
        <div class="form-group row">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-10">
                <?= Html::submitButton('下一步', [
                    'id'    => 'submit_button',
                    'class' => 'btn btn-sm btn-molv btn-very-long',
                ]) ?>
                <?= Html::a('返回', ['forgot-password'], [
                    'id' => 'go_back',
                    'class' => 'btn btn-sm btn-outline-secondary btn-very-long',
                ]); ?>
            </div>
        </div>
    <?php $this->endForm() ?>
</div>
<?php $this->beginScript() ?>
<script>
    $('#sendcode').on('click', function( e ) {
        stopEvent(e);
        var self = $(this);
        var input = $('.username-input');
        var username = input.val();
        if(!username) {
            alert('请输入用户名');
            return;
        }
        self.attr('disabled', 'disabled').text('发送中...');
        var url = '<?= Url::to(['/customer/account/send-forgot-password-code']) ?>';
        $.post(url, {username: username}).then(function( res ) {
            if(res.error) {
                if(res.error === 2) {
                    $.each(res.data, function(k,m) {
                        alert(m);
                        self.removeAttr('disabled').text('发送验证码');
                        return false;
                    });
                    self.removeAttr('disabled').text('发送验证码');
                    return;
                }
                self.removeAttr('disabled').text('发送验证码');
                alert(res.message);
                return;
            }
            downtime(60, function(t) {
                self.attr('disabled', 'disabled').text('重新发送（' + t +'）');
                if(t == 0) {
                    self.removeAttr('disabled').text('发送验证码');
                }
            });
        }, function(xhr, status, error) {
            alert(error);
            self.removeAttr('disabled').text('发送验证码');
        });

    });
</script>
<?php $this->endScript() ?>