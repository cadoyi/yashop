<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $model catalog\models\forms\ProductEditForm
 * @var  $product catalog\models\Product
 * @var  $form yii\widgets\ActiveForm
 */
$categoryAttributeForm = $model->categoryAttributeForm;
?>
<section>
    <?php foreach($categoryAttributeForm->attributes() as $attribute): ?>
         <?= $categoryAttributeForm->render($form, $attribute) ?>
    <?php endforeach; ?>
</section>