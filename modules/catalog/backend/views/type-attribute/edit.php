<?php
use yii\helpers\Html;
use yii\helpers\Url;
use catalog\models\TypeAttribute;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $type catalog\models\Type
 * @var  $model catalog\models\TypeAttribute
 *
 */
$this->title = Yii::t('app', 'Edit product type attribute');
$this->addBreadcrumb(Yii::t('app', 'Manage product types'), ['/catalog/type/index']);
$this->addBreadcrumb(Yii::t('app', 'Manage product type attributes'), ['index', 'type_id' => $type->id ]);

?>
<?php $form = $this->beginForm([
    'id' => 'edit_catalog_type_attribute_form',
]) ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'type_id')->dropDownList([
        $type->id => $type->name,
    ], [
        'readonly' => true,
    ]) ?>
    <?= $form->field($model, 'input_type')->dropDownList(TypeAttribute::inputTypeHashOptions()) ?>
    <?= $form->field($model, 'values')->textarea() ?>
    <?= $form->field($model, 'is_active')->checkbox()->label(Yii::t('app', 'Enabled')) ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-primary'
    ]) ?>
<?php $this->endForm() ?>
