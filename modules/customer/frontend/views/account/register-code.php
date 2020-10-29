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
$this->title = Yii::t('app', 'Register') . ' 验证账号';
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
             'placeholder' => '输入验证码',
        ]) ?>
        <div class="form-group row">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-10">
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
    $('#sendcode').on('click', function( e ) {
        e.preventDefault();
        e.stopPropagation();
        var self = $(this);
        self.attr('disabled', 'disabled').text('发送中...');
        var input = $('.username-input');
        var username = input.val();
        if(!username) {
            alert('请输入用户名');
            return;
        }
        var url = '<?= Url::to(['/customer/account/send-register-code']) ?>';
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
