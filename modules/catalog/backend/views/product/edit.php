<?php
use yii\helpers\Html;
use yii\helpers\Url;
use catalog\models\Brand;
use store\models\Store;
use common\widgets\CKEditorInput;
use core\widgets\Uploader;
?>
<?php 
/**
 * 编辑产品
 *
 * @var  $this yii\web\View
 * @var  $category catalog\models\Category
 * @var  $product catalog\models\Product
 * 
 */
$this->title = Yii::t('app', 'Edit product');
$this->addBreadcrumb(Yii::t('app', 'Manage products'), ['index']);
?>
<?php $form = $this->beginForm([
   'id' => 'edit_catalog_product_form',
]) ?>
<div class="form-buttons text-right border-bottom p-3 mb-2">
    <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
           'class' => 'btn btn-sm btn-primary',
    ])?>
</div>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#basic_info">
            <?= Yii::t('app', 'Basic info') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#product_type">
            <?= Yii::t('app', 'Product type') ?>
        </a>
    </li>    
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#price_info">
            <?= Yii::t('app', 'Price info')?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#stock_info">
            <?= Yii::t('app', 'Stock info') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#product_description">
            <?= Yii::t('app', 'Product description') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#product_options">
            <?= Yii::t('app', 'Product option') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#product_gallery">
            <?= Yii::t('app', 'Product gallery') ?>
        </a>
    </li>
</ul>
<div class="pedit d-flex">
   <div class="tab-content p-3 flex-grow-1">
        <div id="basic_info" class="tab-pane fade active show">
            <?= $form->field($product, 'category_id')->dropDownList([
               $category->id => $category->title,
            ], [
                'readonly' => true,
            ]) ?>
            <?= $form->field($product, 'type_id')->dropDownList([
                $type->id => $type->name,
            ], ['readonly' => true]) ?>
            <?= $form->field($product, 'brand_id')->dropDownList(Brand::hashOptions(), [
                'prompt' => Yii::t('app', 'Please select'),
            ]) ?>
            <?= $form->field($product, 'store_id')->dropDownList(Store::hashOptions(), [
                'prompt' => Yii::t('app', 'Please select'),
            ]) ?>
            <?= $form->field($product, 'title') ?>
            <?= $form->field($product, 'sku') ?>
            <?= $form->field($product, 'image')->widget(Uploader::class, [
                'uploadId' => 'catalog/product/image',
            ]) ?>
            <?= $form->field($product, 'virtual_sales') ?>
            <?= $form->field($product, 'on_sale')->checkbox() ?>
            <?= $form->field($product, 'is_virtual')->checkbox() ?>
            <?= $form->field($product, 'is_part')->checkbox() ?>
            <?= $form->field($product, 'is_hot')->checkbox() ?>
            <?= $form->field($product, 'is_best')->checkbox() ?>
            <?= $form->field($product, 'is_new')->checkbox() ?>
        </div>
        <div id="product_type" class="tab tab-pane">
            <?php foreach($typeAttributeForm->attributes() as $typeName): ?>
                <?= $typeAttributeForm->render($form, $typeName); ?>
            <?php endforeach; ?>
        </div>
        <div id="price_info" class="tab tab-pane">
            <?= $form->field($product, 'price') ?>
            <?= $form->field($product, 'market_price') ?>
            <?= $form->field($product, 'cost_price') ?>
            <?= $form->field($product, 'weight') ?>
            <?= $form->field($product, 'rate') ?>
            <?= $form->field($product, 'promote_price') ?>
            <?= $form->field($product, 'promote_start_date') ?>
            <?= $form->field($product, 'promote_end_date') ?>
        </div>
        <div id="stock_info" class="tab tab-pane">
            <?= $form->field($product, 'stock') ?>
            <?= $form->field($product, 'stock_warning') ?>
        </div>
        <div id="product_options" class="tab tab-pane">
            <?= $this->render('options', [
                 'product' => $product,
                 'form'    => $form,
                 'self'    => $self,
            ])?>
        </div>
        <div id="product_gallery" class="tab tab-pane ">
            <?= $this->render('gallery', [
                'product' => $product,
                'form'    => $form,
                'self'    => $self,
            ])?>
        </div>

        <div id="product_description" class="tab tab-pane">
            <?= $form->field($product, 'description')->widget(CKEditorInput::class) ?>
        </div>
    
    </div>
</div>

<?php $this->endForm() ?>