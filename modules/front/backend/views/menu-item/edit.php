<?php
use yii\helpers\Html;
use yii\helpers\Url;
use cando\link\Widget;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $menu front\models\Menu
 * @var  $model front\models\MenuItem
 *
 */
$menuHashOptions = [];
$menuHashOptions[$menu->id] = $menu->name;
$this->title = Yii::t('app', 'Edit menu item');
$this->addBreadcrumb(Yii::t('app', 'Manage menus'), ['/front/menu/index']);
$this->addBreadcrumb(Yii::t('app', 'Manage menu items'), ['index', 'menu_id' => $menu->id]);
?>
<?php $form = $this->beginForm([
    'id' => 'front_menu_item_edit_form',
]) ?>
   <?= $form->field($model, 'label') ?>
   <?= $form->field($model, 'url')->textarea() ?>
   <?= $form->field($model, 'parent_id')?>
   <?= $form->field($model, 'sort_order') ?>

   <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-sm btn-primary']) ?>
<?php $this->endForm() ?>