<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel catalog\models\filters\BrandFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Edit brand');
$this->addBreadcrumb(Yii::t('app', 'Manage brands'), ['index']);
?>
<?php $form = $this->beginForm([
    'id' => 'edit_catalog_brand_form',
]); ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'sort_order') ?>

    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-primary',
    ])?>
<?php $this->endForm() ?>
