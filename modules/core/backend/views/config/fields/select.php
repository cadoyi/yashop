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
$inputValue = (array) $render->inputValue;
?>
<div class="layui-form-item">
    <label class="layui-form-label">
        <?= Html::encode($field->trans('label')) ?>
    </label>
    <div class="layui-input-block">
        <select 
            name="<?= $render->inputName ?>" 
            lay-verify="required"
            lay-search
            <?php if($field->multiple): ?>
            multiple 
            lay-ignore 
            style="width: 100%; border:1px solid #ddd;height: 100px;resize: vertical;color: #555;"
            <?php endif; ?>
        >
            <?php if(!$field->multiple): ?>
                <option value=""></option>
            <?php endif; ?>
            <?php foreach($field->selectItems as $value => $label): ?>
                <option 
                    value="<?= Html::encode($value) ?>"
                    <?php if(in_array($value, $inputValue)): ?>
                        selected
                    <?php endif; ?>
                ><?= Html::encode($field->t($label)) ?></option>
            <?php endforeach; ?>
      </select>
    </div>
</div>
