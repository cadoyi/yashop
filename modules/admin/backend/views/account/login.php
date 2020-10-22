<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;
use backend\assets\layui\LoginAsset;
LoginAsset::register($this);
?>
<?php
/**
 * @var $this yii\web\View
 * @var $self cando\web\ViewModel
 * @var $model modules\admin\backend\models\LoginView
 */
$this->title = Yii::t('app', 'Login');
$this->registerJsVar('requireCaptcha', $model->canDisplayCaptcha());
?>
<?= Html::beginForm(['/admin/account/login-post'], 'post', [
    'id'         => 'admin_account_login_form',
    'class'      => 'layui-form',
    'lay-filter' => 'login-form',
])?>
    <div class="layui-form-item">
         <div class="layui-input-block ml-0">
              <input type="text" 
                     name="<?= $model->formName() ?>[username]" 
                     placeholder="请输入用户名"
                     autocomplete="off"
                     class="layui-input" 
                     lay-verify="required"
              />
         </div>
    </div>
    <div id="password_div" class="layui-form-item">
         <div class="layui-input-block ml-0">
              <input type="password" 
                     name="<?= $model->formName() ?>[password]" 
                     placeholder="请输入密码"
                     autocomplete="off"
                     class="layui-input"
                     lay-verify="required"
              />
         </div>
    </div>
    <div class="layui-form-item">
         <div class="layui-input-block ml-0">
              <input type="hidden" name="<?= $model->formName()?>[remember]" value="0" />
              <input type="checkbox"
                     value="1" 
                     name="<?= $model->formName() ?>[remember]" 
                     title="记住我"
                     checked
              />
         </div>
    </div>
    <div class="layui-form-item mb-0">
        <button  class="layui-btn layui-btn-fluid"  
                 lay-submit 
                 lay-filter="submit"
        >
             登录
        </button>
    </div>
<?= Html::endForm() ?>
<template id="captcha_template">
    <div class="layui-form-item captcha-div">
         <div class="layui-input-block ml-0 d-flex">
              <input type="input" 
                     name="<?= $model->formName() ?>[code]" 
                     placeholder="请输入验证码"
                     autocomplete="off"
                     class="layui-input"
                     lay-verify="required"
              />
              <img class="border border-left-0"
                   refresh="<?= Url::to(['/admin/account/captcha', 'refresh' => 1 ])?>"
                   src="<?= Url::to(['/admin/account/captcha', 'v' => uniqid('', true)]) ?>" 
              />
         </div>
    </div>
</template>
<?php $this->beginScript() ?>
<script>
    var rebuildCaptchaInput = function() {
        var isExists = document.getElementById('captcha_div');
        if(!isExists) {
            var html = $('#captcha_template').html();
            var captcha = $(html);
            captcha.attr('id', 'captcha_div');
            captcha.insertAfter('#password_div');
        }
    };
    if(requireCaptcha) {
         rebuildCaptchaInput();
    }
    layui.form.on('submit(submit)', function( data ) {
        var button = new helper.Button(this);
        button.lock('登录中...');
        $.post(data.form.action, data.field).then(function( res ) {
            if(res.error) {
                if(res.data.captcha) {
                    rebuildCaptchaInput();
                }
                layui.layer.msg(res.message);
            } else {
                layui.layer.msg('登录成功');
                var url = res.data.url;
                location.href = url;
            }
            button.unlock('登录');
        }, function( xhr, error, message ) {
             layui.layer.msg(message);
             button.unlock('登录');
        });
        return false;
    });

    $(document).on('click', '.captcha-div img', function( e ) {
        e.preventDefault();
        e.stopPropagation();
        var img = $(this);
        var refreshUrl = img.attr('refresh');
        $.get(refreshUrl).then(function( res ) {
            img.attr('src', res.url);
        });
    });
</script>
<?php $this->endScript() ?>



