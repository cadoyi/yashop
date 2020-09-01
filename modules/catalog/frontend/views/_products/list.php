<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $category catalog\models\Category;
 * @var  $filterModel catalog\models\filters\CategoryProductFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
?>
<style>
    .category-head {
        border: 1px solid #ddd;
        border-left: 0;
        border-right: 0;
        padding: .75rem 1rem;
    }
    .product {
        width: 250px;
        border-radius: 0;
        padding: 1rem .5rem;
    }
    #link_pager {
        padding: 1rem;
        text-align: center;
    }
    
    @media ( min-width: 768px ) {
        .category-products-wrapper { width: 750px; margin:auto;}
    } 
    @media ( min-width: 1001px) {
        .category-products-wrapper { width: 1000px; margin:auto;}
    }

</style>
<div class="d-flex flex-nowrap category-head">
    <div>相关商品: <span style="color:red;"><?= $dataProvider->getTotalCount() ?></span> 个</div>
    <div class="flex-grow-1">&nbsp;</div>
</div>
<div class="category-products p-3 d-flex justify-content-center">
    <div class="category-products-wrapper d-flex flex-wrap justify-content-start">
<?php for($i=0; $i< 20; $i++): ?>
    <?php foreach($dataProvider->getModels() as $product): ?>
        <div class="product">
            <a class="card" href="<?= Url::to(['/catalog/product/view', 'id' => $product->id]) ?>">
                <img class="card-img-top" src="<?= $product->getImageUrl(400) ?>" />
                <div class="card-body p-2">
                    <div class="d-flex flex-nowrap justify-content-between py-1" style="line-height: 1.5rem;">
                        <div style="font-size: 1.2rem; color: red;">&yen; <?= $product->finalPrice ?></div>
                        <div><del>&yen; <?= $product->market_price ?></del></div>
                    </div>
                    <div><?= Html::encode($product->name) ?></div>
                    <div class="text-right">销量: <?= $product->getSalesCount() ?></div>
                </div>
           </a>
       </div>
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