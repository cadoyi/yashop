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
$category = $product->category;
?>
<section>
    <?= $form->field($model->inventoryForm, 'qty') ?>
    <?= $form->field($model->inventoryForm, 'qty_warning') ?>
</section>