<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $model customer\frontend\models\account\ForgotPasswordForm
 */
$this->title = Yii::t('app', 'Forgot password');
?>
<div class="p-3" style="width: 350px;">
<?php $form = $this->beginForm([
    'id' => 'customer_forgot_password_form',
    'layout' => 'default',
]) ?>
   <?= $form->field($model, 'username') ?>
   <?= $form->field($model, 'captcha')->widget(Captcha::class, [
       'captchaAction' => ['/customer/account/captcha'],
        'template' => '<div class="d-flex">{input} <div class="border">{image}</div></div>'
   ])->label('图片验证码') ?>
   <div class="d-flex">
       <?= $form->field($model, 'code', [
        'options' => [
            'class' => 'form-group flex-grow-1',
        ],
        
    ]) ?>
       <div class="form-group">
           <label class="label-control">&nbsp;</label>
           <a id="send_forgot_code" 
              class="text-nowrap d-block btn btn-outline-secondary rounded-0" 
              href="#"
           >
               发送验证码
           </a>
       </div>
   </div>
   <?= Html::submitButton(Yii::t('app', 'Next step'), [
       'class' => 'btn btn-sm btn-primary',
   ]) ?>
<?php $this->endForm() ?>
</div>
<?php $this->beginScript() ?>
<script>
    var form = $('#customer_forgot_password_form');
    var validateField = function(id) {
        var 
        attribute = form.yiiActiveForm('find', id),
        input = $('#' + id),
        messages = [],
        defer = $.Deferred();
        attribute.validate(attribute, input.val(), messages, defer, form);
        if(messages.length) {
            var error = {};
            error[id] = messages;
            form.yiiActiveForm('updateMessages', error);
            return false;
        }
        return true;
    };
    var sendCodeUrl = '<?= Url::to(['/customer/account/send-forgot-password-code']) ?>';
    $('#send_forgot_code').on('click', function( e ) {
        stopEvent(e);
        var id = 'forgotpasswordform-username';
        var codeId = 'forgotpasswordform-captcha';
        if(!validateField(id) || !validateField(codeId)) {
            return;
        }
        $.post(sendCodeUrl, {
            'username': $('#' + id).val(),
            'captcha': $('#' + codeId).val(),
        }).then(function( res ) {
            if(res.success) {
                alert('验证码已经发送');
            } else {
                alert(res.message);
            }
        }, function() {
            alert('网络错误');
        });
    });
</script>
<?php $this->endScript() ?>