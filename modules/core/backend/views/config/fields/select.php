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
<?= $form->field($field->model, 'value')
   ->dropDownList($field->selectItems, array_merge($field->options, [
       'id'     => $render->inputId,
       'name'   => $render->inputName,
       'value'  => $render->inputValue,
       'prompt' => '',
   ])) 
?>
