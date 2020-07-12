<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $self  cando\web\ViewModel
 * @var  $model customer\models\CustomerGroup
 * 
 */
$this->title = Yii::t('app', 'Edit customer group');
$this->addBreadcrumb(Yii::t('app', 'Customer group'), ['index']);
?>
<?php $form = ActiveForm::begin([
    'id' => 'edit_customer_group',
]) ?>
    <?= $form->field($model, 'name') ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-primary',
    ]) ?>
<?php ActiveForm::end() ?>
