<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use cando\rbac\widgets\SelectRole;
//use common\widgets\FileInput;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $self cando\web\ViewModel
 * @var  $model modules\admin\backend\models\user\Edit
 */
$this->title = Yii::t('app', 'Create user');
$this->addBreadcrumb(Yii::t('app', 'Manage user'), ['index']);
?>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#basic_info">
            <?= Yii::t('app', 'Basic info') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#role_info">
            <?= Yii::t('app', 'Role info') ?>
        </a>
    </li>
</ul>

<?php $form = $this->beginForm([
   'id' => 'edit_user_form',   
]) ?>
<div class="tab-content p-3">
    <div id="basic_info" class="tab-pane fade active show">
        <?= $form->field($model, 'username')->textInput([
            'disabled' => !$model->isNewRecord,
        ]) ?>
        <?= $form->field($model, 'nickname') ?>
        <?php /*
        <?= $form->field($model, 'avatar')->widget(FileInput::class, [
            'width'  => '100px',
            'height' => '100px',
            'url'    => $model->getAvatarUrl(),
        ]) ?>
        */ ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_confirm')->passwordInput() ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>
        <?= $form->field($model, 'admin_password')->passwordInput() ?>
    </div>
    <div id="role_info" class="tab-pane fade">

        <?= $form->field($model, 'role')->widget(SelectRole::class, [
            'user_id'  => $model->id,
            'multiple' => false,
        ]) ?>

    </div>
</div>
    <?= Html::submitButton(Yii::t('app', 'Submit'), [
        'class' => 'btn btn-sm btn-primary',
    ]) ?>
<?php $this->endForm() ?>
