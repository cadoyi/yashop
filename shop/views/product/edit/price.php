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
    <fieldset class="box">
        <legend>价格设置</legend>
    <?= $form->field($product, 'price') ?>
    <?= $form->field($product, 'market_price') ?>
    <?= $form->field($product, 'cost_price') ?>
    </fieldset>
    <fieldset class="box">
        <legend>运费相关</legend>
        <div class="d-flex">
            <div class="col-sm-2 px-0">
                <div class="form-group">
                    <label>产品重量</label>
                </div>
            </div>
            <div class="col-sm-10 d-flex px-0">
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
                ])->label(false) ?>
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
                ])->label(false) ?>
            </div>
        </div>
        <?= $form->field($product, 'rate') ?>

        
    </fieldset>
    <fieldset class="box">
        <legend>促销信息</legend>
        <?= $form->field($product, 'promote_price') ?>
        <?= $form->field($product, 'promote_start_date') ?>
        <?= $form->field($product, 'promote_end_date') ?>        
    </fieldset>

</section>