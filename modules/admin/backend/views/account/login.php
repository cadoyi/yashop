<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;
?>
<?php
/**
 * @var $this yii\web\View
 * @var $self cando\web\ViewModel
 * @var $model modules\admin\backend\models\LoginView
 */
$this->title = Yii::t('app', 'Login');
?>

<div class="input-wrapper">
  <div class="text-center mb-4">
      <h1 class="h3"><?= Yii::t('app', 'Login') ?></h1>
  </div>
   <?php $form = ActiveForm::begin([
       'id' => 'login_form',
       'enableClientValidation' => false,
       'options' => [
            'autocomplete' => "off",
       ],
   ]) ?> 
        <div class="">
          <div class="no-label">
            <?= $form->field($model, 'username', [
                'template' => $self->getUsernameTemplate(),
            ])->textInput([
                'placeholder' => Yii::t('app', 'Please input {attribute}', [
                    'attribute' => $model->getAttributeLabel('username'),
                ]),
            ]) ?>


            <?= $form->field($model, 'password', [
                'template' => $self->getPasswordTemplate(),
            ])->passwordInput([
                'placeholder' => Yii::t('app', 'Please input {attribute}', [
                     'attribute' => $model->getAttributeLabel('password'),
                ]),
            ])?>

            <?php if($model->canDisplayCaptcha()): ?>
                <?= $form->field($model, 'code')->label('') -> widget(Captcha::class, [
                    'captchaAction' => $self->getCaptchaAction(),
                    'template' => $self->getCaptchaTemplate(),
                    'options' => [
                         'placeholder' => Yii::t('app', 'Captcha code'),
                    ],
                ]) ?>
            <?php endif; ?>
          </div>
            
            <div class="form-group mb-3">
                <?= Html::submitButton(Yii::t('app', 'Login'), [
                    'class' => 'btn btn-primary btn-block',
                ])?>
            </div>
            <?= $form->field($model, 'remember')->checkbox() ?>
        </div>
    <?php ActiveForm::end() ?>
</div>




