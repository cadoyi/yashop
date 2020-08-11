<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $category catalog\models\Category;
 * @var  $filterModel catalog\models\filters\CategoryProductFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */

$this->title = $category->title;
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
    }
</style>
<div class="d-flex flex-nowrap category-head">
    <div>相关商品: <span style="color:red;"><?= $dataProvider->getTotalCount() ?></span> 个</div>
    <div class="flex-grow-1">&nbsp;</div>
</div>
<div class="category-products p-3 d-flex flex-wrap">
    <?php foreach($dataProvider->getModels() as $product): ?>
        <a class="product card" href="<?= Url::to(['/catalog/product/view', 'id' => (string) $product->id]) ?>">
            <img class="card-img-top" src="<?= Yii::$app->storage->getUrl($product->image) ?>" />
            <div class="card-body">
                <div><?= $product->name ?></div>
                <div>&yen; <?= $product->price ?></div>
                <div><del>&yen; <?= $product->market_price ?></del></div>
            </div>
       </a>
    <?php endforeach; ?>
</div>