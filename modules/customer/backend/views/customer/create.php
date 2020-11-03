<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model customer\backend\models\customer\Create
 *
 * 
 */
$this->title = Yii::t('app', 'Add new customer');
$this->addBreadcrumb(Yii::t('app', 'Manage customers'), ['index']);
?>
<?php $form = $this->beginForm([
    'id' => 'create_customer_form',
]) ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'phone') ?>
    <?= $form->field($model, 'nickname') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password_confirm')->passwordInput() ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-molv',
    ]) ?>
    <?= Html::submitButton(Yii::t('app', 'Save and continue'), [
        'class' => 'btn btn-sm btn-molv',
        'data-method' => 'post',
        'data-params' => ['continue' => 1 ],
    ]) ?>    
<?php $this->endForm() ?>
