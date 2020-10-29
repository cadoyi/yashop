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
<?= $form->field($field->model, 'value')->textarea([
    'id'    => $render->inputId,
    'name'  => $render->inputName,
    'value' => $render->inputValue,
]) ?>

