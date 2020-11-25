<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;
use frontend\assets\basic\catalog\ProductListAsset;
ProductListAsset::register($this);

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $category catalog\models\Category;
 * @var  $filterModel catalog\models\filters\CategoryProductFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
?>

<div class="d-flex flex-nowrap category-head">
    <div>相关商品: <span style="color:red;"><?= $dataProvider->getTotalCount() ?></span> 个</div>
    <div class="flex-grow-1">&nbsp;</div>
</div>
<div class="category-products p-3 d-flex justify-content-center">
    <div class="category-products-wrapper d-flex flex-wrap justify-content-start">
<?php for($i=0; $i< 20; $i++): ?>
    <?php foreach($dataProvider->getModels() as $product): ?>
         <?= $this->render('@frontend/views/_common/product', [
             'product' => $product,
         ]) ?>
    <?php endforeach; ?>
<?php endfor; ?>
</div>
</div>
<?=  LinkPager::widget([
    'id' => 'link_pager',
    'pagination' => $dataProvider->pagination,
    'options' => [
        'class' => 'd-flex justify-content-center',
    ],
]) ?>