<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model issue\models\Category
 * 
 */
$this->title = Yii::t('app', 'Edit issue category');
$this->addBreadcrumb(Yii::t('app', 'Manage issue categories'), ['index']);
?>
<?php $form = $this->beginForm([
    'id' => 'edit_issue_category_form',
]); ?>
    <?= $form->field($model, 'code')->textInput([
        'readonly' => !$model->isNewRecord,
    ]) ?>
    <?= $form->field($model, 'title') ?>

    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-molv',
    ])?>
<?php $this->endForm() ?>
