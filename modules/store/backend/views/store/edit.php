<?php
use yii\helpers\Html;
use yii\helpers\Url;
use store\models\Store;
use core\widgets\Uploader;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model store\models\Profile
 *
 * 
 */
$this->title = Yii::t('app', 'Edit store');
$this->addBreadcrumb(Yii::t('app', 'Manage stores'), ['index']);
?>
<?php $form = $this->beginForm([
    'id' => 'edit_store_profile_form',
]) ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'logo')->widget(Uploader::class, [
        'uploadId' => 'store/store/logo',
    ]) ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'type')->dropDownList(Store::typeHashOptions(), [
        'prompt' => Yii::t('app', 'Please select'),
    ]) ?>
    <?= $form->field($model, 'company_name') ?>
    <?= $form->field($model, 'legal_person') ?>
    <?= $form->field($model, 'phone') ?>
    <?= $form->field($model, 'status')->dropDownList(Store::statusHashOptions(), [
        'prompt' => Yii::t('app', 'Please select'),
    ]) ?>
    <?= $form->field($model, 'is_platform')->checkbox() ?>
    <?= $form->field($model, 'note')->textarea() ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'btn btn-sm btn-primary',
    ]) ?>
<?php $this->endForm() ?>