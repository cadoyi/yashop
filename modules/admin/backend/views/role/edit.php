<?php
use yii\helpers\Html;
use yii\helpers\Url;
use cando\rbac\widgets\SelectPermission;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $self cando\web\ViewModel
 * @var  $model cando\rbac\models\Role
 *
 * 
 */
$this->title = Yii::t('app', 'Edit role');
$this->addBreadcrumb(Yii::t('app', 'Manage roles'), ['index']);
?>
<div class="text-right">

</div>
<div class="mw-500">
<?php $form = $this->beginForm([
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

<?php $this->endForm() ?>
</div>