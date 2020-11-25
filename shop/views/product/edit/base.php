<?php
use yii\helpers\Html;
use yii\helpers\Url;
use catalog\models\Brand;
use store\models\Store;
use cando\storage\widgets\Uploader;
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
    <?= $form->field($product, 'title') ?>
    <?= $form->field($product, 'sku') ?>
    <?= $form->field($product, 'category_id')->dropDownList([
       $category->id => $category->title,
    ], [
        'readonly' => true,
    ]) ?>
    <?= $form->field($product, 'brand_id')->dropDownList(Brand::hashOptions(), [
        'prompt' => Yii::t('app', 'Please select'),
    ]) ?>

    
    <?= $form->field($product, 'image')->widget(Uploader::class, [
        'uploadUrl' => ['/file/upload' , 'id' => 'catalog/product/image'],
        'url' => $product->getImageUrl(),
    ]) ?>
    <?= $form->field($product, 'is_virtual')->checkbox() ?>

    <fieldset class="box">
        <legend>搜索相关</legend>
        <?= $form->field($product, 'meta_keywords')->textarea() ?>
        <?= $form->field($product, 'meta_description')->textarea() ?>
    </fieldset>
</section>