<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use cando\rbac\widgets\SelectPermission;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $params cando\web\ViewModel
 * @var  $model cando\rbac\models\Role
 *
 * 
 */
$model = $params->model;
$this->title = Yii::t('app', 'Edit role');
$this->addBreadcrumb(Yii::t('app', 'Manage roles'), ['index']);
?>
<div class="text-right">

</div>
<div class="mw-500">
<?php $form = ActiveForm::begin([
    'id' => 'edit_role_form',
]) ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'label') ?>
<?= $form->field($model, 'description')->textarea() ?>
<?= $form->field($model, 'permissions')->widget(SelectPermission::class, [
    'roleName' => $model->name,
]) ?>    
<?= Html::submitButton(Yii::t('app', 'Save'), [
    'class' => 'btn btn-sm btn-primary',
])?>

<?php ActiveForm::end() ?>
</div>