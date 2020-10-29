<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use cando\config\system\widgets\Menu;
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
//$this->addBreadcrumb(Yii::t('app', 'System config') , ['edit']);

?>
<div class="d-flex flex-nowrap" style="margin-left: -15px; margin-right: -15px; margin-top: -1rem;min-height: 100%;">
    <?= Menu::widget([
        'system' => $section->system,
        'options' => [
            'class' => 'layui-nav layui-nav-tree layui-bg-white',
            'lay-filter' => 'config_menu',
        ],
        'itemOptions' => [
             'class' => 'layui-nav-item layui-nav-itemed',
        ],
        'submenuTemplate' => '<ul class="layui-nav-child">{items}</ul>',
        'activeCssClass' => 'layui-this',
    ])?>
    <div class="flex-grow-1 p-3">
        <?= Html::BeginForm(
            ['/core/config/save', 'section' => $section->name], 
            'post', 
            [
                'class' => 'layui-form',
                'id' => 'config_form',
            ]
    ) ?>
        <div class="layui-form-item border-bottom pb-3 text-right">
            <button class="layui-btn layui-btn-sm" lay-submit lay-filter="submit">立即保存</button>
        </div>
        <div class="layui-collapse">
            <?php foreach($section->fieldsets as $fieldset): ?>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">
                         <?= Html::encode($fieldset->trans('label')) ?>         
                    </h2>
                    <div class="layui-colla-content layui-show">
                        <?php foreach($fieldset->fields as $field): ?>
                            <?= $field->render->render() ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>    
<script>
    if(window.layui) {
        layui.element.render('nav', 'config_menu');
    }
</script>
<?php $this->beginScript() ?>
<script>
    layui.form.on('submit(submit)', function( data ) {
        var button = $(data.elem);
        button.attr('disabled', 'disabled')
              .addClass('layui-btn-disabled')
              .text('保存中..');
        $.post(data.form.action, data.field).then(function( e ) {
            if(e.error) {
                layui.layer.msg(e.message);
            } else {
                layui.layer.msg('保存成功！');
            }
            button.removeAttr('disabled')
                  .removeClass('layui-btn-disabled')
                  .text('立即保存');
        });
        return false;
    });
</script>
<?php $this->endScript() ?>