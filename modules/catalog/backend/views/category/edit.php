<?php
use yii\helpers\Html;
use yii\helpers\Url;
use catalog\widgets\CategorySelector;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model catalog\models\Category
 * 
 */
$this->title = Yii::t('app', 'Edit category');
$this->addBreadcrumb(Yii::t('app', 'Manage categories'), ['index']);
?>
<?php $form = $this->beginForm(['id' => 'edit_catalog_category_form']) ?>
    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'parent_id')->widget(CategorySelector::class, [
        'disableParent' => false,
       'options' => [
           'prompt' => Yii::t('app', 'Please select'),
       ],
    ])?>
    <?= $form->field($model, 'sort_order') ?>

    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-molv',
    ]) ?>
<?php $this->endForm() ?>