<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $params modules\core\backend\vms\config\Edit
 */
?>
<?php $form = ActiveForm::begin([
   'id' => 'edit_core_config_form',
]) ?>
   <?php foreach($params->fieldsets as $fieldset): ?>
       <?php foreach($fieldset->fields as $field): ?>
            <?= $field->render($form) ?>
       <?php endforeach; ?>
   <?php endforeach; ?>

<?php ActiveForm::end() ?>
