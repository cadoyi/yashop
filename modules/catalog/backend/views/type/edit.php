<?php
use yii\helpers\Html;
use yii\helpers\Url;
use catalog\widgets\CategorySelector;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model catalog\models\Type
 * 
 */
$this->title = Yii::t('app', 'Edit product type');
$this->addBreadcrumb(Yii::t('app', 'Manage product types'), ['index']);
?>
<?php $form = $this->beginForm([
    'id' => 'edit_catalog_type_form',
]) ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'category_id')->widget(CategorySelector::class) ?>

    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-primary',
    ]) ?>
<?php $this->endForm() ?>