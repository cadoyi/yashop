<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use cando\config\widgets\Menu;
use backend\assets\basic\core\config\EditAsset;
EditAsset::register($this);
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $params modules\core\backend\vms\config\Edit
 * @var  $section cando\config\system\Section
 * @var  $config cando\config\System
 */
$section = $params->section;
$config = $section->config;

$this->title = $section->t('label');
$this->addBreadcrumb(Yii::t('app', 'System config') , ['edit']);

?>
<div class="d-flex config-edit">
    <div class="config-menu">
        <?= Menu::widget([
            'config' => $config,
        ])?>
    </div>
    <div class="config-container flex-grow-1">
         <?php $form = ActiveForm::begin([
             'id' => 'edit_config_form',
         ]) ?>
         <div class="config-container-header border-bottom mb-3 pb-2">
            <div class="d-flex flex-nowrap">
                 <div class="flex-grow-1">
                     <span><?= Html::encode($section->t('label')) ?></span>
                 </div>
                 <?= Html::submitButton(Yii::t('app', 'Save'), [
                      'class' => "btn btn-sm btn-outline-primary rounded-0"
                 ]) ?>
             </div>
         </div>
         <?php foreach($section->fieldsets as $fieldset): ?>
           <?= $fieldset->render($form) ?>  
         <?php endforeach; ?>

         <?php ActiveForm::end() ?>
    </div>
</div>