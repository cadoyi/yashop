<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;
use backend\assets\bs4\admin\LoginAsset;
LoginAsset::register($this);
?>
<?php
/**
 * @var $this yii\web\View
 * @var $self cando\web\ViewModel
 * @var $model modules\admin\backend\models\LoginView
 */
$this->title = Yii::t('app', 'Login');
?>

<?php $form = $this->beginForm([
    'id' => 'login_form',
    'layout' => 'default',
    'options' => [
        'class' => 'login-form',
    ],
]) ?>
    <?= $form->field($model, 'username')
         ->textInput([
             'placeholder' => '请输入用户名',
         ])
         ->label(false)
    ?>

    <?= $form->field($model, 'password')
        ->passwordInput([
            'placeholder' => '请输入密码',
        ])
        ->label(false)
    ?>

    <?php if($model->canDisplayCaptcha()): ?>
        <?= $form->field($model, 'code')->widget(Captcha::class, [
            'captchaAction' => '/admin/account/captcha',
            'template' => '<div class="d-flex flex-nowrap">{input} {image}</div>',
            'options' => [
                'placeholder' => '请输入验证码',
            ],
        ])->label(false) ?>
    <?php endif; ?>

    <?= $form->field($model, 'remember')->checkbox() ?>

    <?= Html::submitButton('立即登录', [
        'class' => 'btn btn-molv btn-block',
    ]) ?>

<?php $this->endForm() ?>



