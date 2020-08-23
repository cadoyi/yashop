<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

?>
<?php 
/**
 * @var  $this yii\web\View
 *
 * 
 */
$this->title = Yii::t('app', 'Login');
?>
<div class="login-container">
    <div class="d-flex flex-nowrap">
        <div class="form-wrapper shadow">
            <div class="form-wrapper-header d-flex">
                <div class="flex-grow-1">客户登录</div>
            </div>
            <?php $form = $this->beginForm([
                'id' => 'login_form',
                'layout' => 'default',
            ]) ?>
                <?= $form->field($model, 'username')->textInput([
                   'placeholder' => '邮件地址或手机号码',
                ])->label('') ?>
                <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => '请输入密码',
                ])->label('') ?>
                <?php if($model->scenario === 'captcha'): ?>
                    <?= $form->field($model, 'code')->widget(Captcha::class, [
                        'template' => '<div class="d-flex flex-nowrap">{input} {image}</div>',
                        'captchaAction' => '/customer/account/captcha',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => '验证码',
                        ],
                    ])->label('') ?>
                <?php endif; ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Login'), [
                         'class' => 'btn btn-block btn-primary rounded-0',
                    ]) ?>
                </div>
                <div class="d-flex links">
                    <?php if($model->rememberEnabled()): ?>
                        <?= $form->field($model, 'remember')->checkbox() ?>
                    <?php endif; ?>
                    <div class="ml-auto">
                        <a href="<?= Url::to(['forgot-password']) ?>">忘记密码</a>
                        <a href="<?= Url::to(['register']) ?>">立即注册</a>
                    </div>
                </div>
            <?php $this->endForm() ?>
            <div class="form-wrapper-footer">
                其他登录方式
                  <a class="d-inline mx-2 wechat-link" href="<?= Url::to(['/customer/weixin/login'])?>">
                      <i class="fa fa-weixin"></i>
                  </a>
            </div>
        </div>
    </div>
</div>