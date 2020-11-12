<?php
use yii\helpers\Html;
use yii\helpers\Url;
use catalog\models\Brand;
use store\models\Store;
use backend\widgets\CKEditorInput;
use core\widgets\Uploader;
use backend\assets\bs4\catalog\ProductAsset;
ProductAsset::register($this);
?>
<?php 
/**
 * 编辑产品
 *
 * @var  $this     yii\web\View
 * @var  $model    catalog\backend\models\ProductForm
 * @var  $category catalog\models\Category
 * @var  $product  catalog\models\Product
 * @var  $type     catalog\models\Type
 * 
 */
$product  = $model->product;
$type     = $model->type;
$category = $model->category;

$this->title = Yii::t('app', 'Edit product');
$this->addBreadcrumb(Yii::t('app', 'Manage products'), ['index']);
?>
<?php $form = $this->beginForm([
   'id' => 'edit_catalog_product_form',
]) ?>

<ul class="nav nav-tabs nav-tabs-brief">
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
        <a class="nav-link" data-toggle="tab" href="#product_gallery">
            <?= Yii::t('app', 'Product gallery') ?>
        </a>
    </li>    
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#product_options">
            <?= Yii::t('app', 'Product option') ?>
        </a>
    </li>
    <?php if(!$product->isNewRecord && $product->is_selectable): ?> 
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#product_skus">
            <?= Yii::t('app', 'Product SKU') ?>
        </a>
    </li> 
    <?php endif; ?>
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
            <?= $form->field($model->salesForm, 'virtual_sales') ?>
            <?= $form->field($product, 'status')->checkbox() ?>
            <?= $form->field($product, 'is_virtual')->checkbox() ?>
            <?= $form->field($product, 'is_hot')->checkbox() ?>
            <?= $form->field($product, 'is_best')->checkbox() ?>
            <?= $form->field($product, 'is_new')->checkbox() ?>
        </div>
        <div id="product_type" class="tab tab-pane">
            <?php foreach($model->typeAttribute->attributes() as $typeAttributeName): ?>
                 <?= $model->typeAttribute->render($form, $typeAttributeName) ?>
            <?php endforeach; ?>
        </div>
        <div id="price_info" class="tab tab-pane">
            <?= $form->field($product, 'price') ?>
            <?= $form->field($product, 'market_price') ?>
            <?= $form->field($product, 'cost_price') ?>
            <div class="d-flex">
                <label class="col-sm-2">产品重量</label>
                <div class="col-sm-10 d-flex">
                <?= $form->field($product, 'weight', [
                    'options' => [
                        'class' => 'form-group flex-grow-1',
                    ],
                    'horizontalCssClasses' => [
                        'offset' => '',
                        'label' => '',
                        'wrapper' => '',
                        'error' => '',
                        'hint' => '',
                        'field' => 'form-group row'
                    ],
                ])->label('') ?>
                <?= $form->field($product, 'weight_unit', [
                     'horizontalCssClasses' => [
                        'offset' => '',
                        'label' => '',
                        'wrapper' => '',
                        'error' => '',
                        'hint' => '',
                        'field' => 'form-group'
                    ],      
                ])->dropDownList([
                    'g'  => '克',
                    'kg' => '千克', 
                ])->label('') ?>
                </div>
            </div>
            <?= $form->field($product, 'rate') ?>
            <?= $form->field($product, 'promote_price') ?>
            <?= $form->field($product, 'promote_start_date') ?>
            <?= $form->field($product, 'promote_end_date') ?>
        </div>
        <div id="stock_info" class="tab tab-pane">
            <?= $form->field($model->inventoryForm, 'qty') ?>
            <?= $form->field($model->inventoryForm, 'qty_warning') ?>
        </div>

        <div id="product_gallery" class="tab tab-pane ">
       
            <?= $this->render('gallery', [
                'product' => $product,
                'form'    => $form,
                'model'   => $model,
                'self'    => $self,
            ])?>
        </div>

        <div id="product_description" class="tab tab-pane">
            <?= $form->field($product, 'description')->widget(CKEditorInput::class) ?>
        </div>
        <div id="product_options" class="tab tab-pane">
            <?= $form->field($product, 'is_selectable')->checkbox() ?>
            <?= $this->render('option', [
                 'product' => $product,
                 'form'    => $form,
                 'self'    => $self,
                 'model'   => $model,
            ])?>
        </div>
        <?php if(!$product->isNewRecord && $product->is_selectable): ?>
        <div id="product_skus" class="tab tab-pane">
            <?= $this->render('skus', [
                'product'      => $product,
                'filterModel'  => $filterModel,
                'dataProvider' => $dataProvider,
            ])?>
        </div>
        <?php endif; ?>
    </div>
</div>
<div class="form-buttons p-3 mb-2">
    <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-sm btn-outline-secondary btn-long']) ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
           'class' => 'btn btn-sm btn-molv',
    ])?>
</div>
<?php $this->endForm() ?>