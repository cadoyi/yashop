<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\bs4\core\ConfigAsset;
use cando\config\system\widgets\Menu;

ConfigAsset::register($this);
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $params modules\core\backend\vms\config\Edit
 * @var  $section cando\config\system\Section
 * @var  $config cando\config\System
 */
$config = $section->config;
$this->title = $section->trans('label');
$this->addBreadcrumb(Yii::t('app', 'System config') , ['edit']);

?>
<div class="d-flex flex-nowrap">
    <?= Menu::widget([
        'system' => $section->system,
        'options' => [
            'class' => 'config-menu',
            'id'    => 'config_menu',
        ],
        'linkTemplate' => '<a href="{url}">{label}<i class="fa fa-caret-left"></i><i class="fa fa-caret-down"></i></a>',
        'activateParents' => true,
    ])?>
    <div class="flex-grow-1 p-3">

        <?php $form = $this->beginForm([
            'id' => 'config_form',
            'action' => ['/core/config/save', 'section' => $section->name ],
            'options' => [
                'class' => 'config-form',
            ],
            'fieldConfig' => [
                 'horizontalCssClasses' => [
                      'label' => 'col-sm-3',
                      'offset' => 'offset-sm-3',
                      'wrapper' => 'col-sm-9',
                      'error' => '',
                      'hint' => '',
                ],
            ]

        ]) ?>
        <div class="border-bottom pb-3 mb-3 text-right">
            <button id="submit_button"  type="submit" class="btn btn-sm btn-molv">立即保存</button>
        </div>        
            <?php foreach($section->fieldsets as $fieldset): ?>
                <div class="fieldset">
                    <div class="fieldset-title">
                        <h2><?= Html::encode($fieldset->trans('label')) ?></h2>
                    </div>
                    <div class="fieldset-body">
                        <?php foreach($fieldset->fields as $field): ?>
                            <?= $field->render->render([
                                'form' => $form,
                            ]); ?>
                        <?php endforeach; ?>
                   </div>
                </div>
            <?php endforeach; ?>
        <?php $this->endForm() ?>
    </div>
</div>
<?php $this->beginScript() ?>
<script>
    $('#config_form').on('beforeSubmit', function( e ) {
        e.preventDefault();
        var form = $(this);
        var data = form.serializeArray();
        var url = form.attr('action');
        $('#submit_button').attr('disabled', 'disabled').text('保存中');
        $.post(url, data).then(function( res ) {
            if(res.error) {
                op.error({text: res.message});
            } else {
                op.success({timer: 3000});
            }
            $('#submit_button').removeAttr('disabled').text('立即保存');
        }, function(xhr, status,statusText) {
            op.error({title: status, 'text': statusText});
            $('#submit_button').removeAttr('disabled').text('立即保存');
        });
        return false;
    });
</script>
<?php $this->endScript() ?>
