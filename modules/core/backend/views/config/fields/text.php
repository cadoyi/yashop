<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * 渲染 text 字段
 *
 * @var  $this yii\web\View
 * @var  $field Field
 */
?>
<div class="layui-form-item">
    <label class="layui-form-label">
        <?= Html::encode($field->trans('label')) ?>
    </label>
    <div class="layui-input-block">
        <input 
            id="<?= $render->inputId ?>"
            class="layui-input"
            type="text" 
            name="<?= $render->inputName ?>"
            placeholder="请输入内容"
            value="<?= Html::encode($render->inputValue) ?>"
        />
    </div>
</div>
