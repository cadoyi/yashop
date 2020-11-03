<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model cms\models\Category
 * 
 */
$this->title = Yii::t('app', 'Edit category');
$this->addBreadcrumb(Yii::t('app', 'Manage article categories'), ['index']);
?>
<?php $form = $this->beginForm([
    'id' => 'edit_cms_category_form',
]) ?>
   <?= $form->field($model, 'name') ?>
   <?= $form->field($model, 'description')->textarea() ?>
   <?= Html::submitButton(Yii::t('app', 'Save'), [
       'class' => 'btn btn-sm btn-molv btn-long',
   ])?>
<?php $this->endForm() ?>