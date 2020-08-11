<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * edit menu
 * @var  $this yii\web\View
 * @var  $model front\models\Menu
 */
$this->title = Yii::t('app', 'Edit menu');
$this->addBreadcrumb(Yii::t('app', 'Manage menus'), ['index']);
?>
<?php $form = $this->beginForm([
    'id' => 'front_menu_edit_form',
]) ?>
   <?= $form->field($model, 'name') ?>
   <?= $form->field($model, 'code') ?>
   <?= Html::submitButton(Yii::t('app', 'Save'), [
       'class' => 'btn btn-sm btn-primary',
   ]) ?>
<?php $this->endForm() ?>