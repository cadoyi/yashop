<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * 渲染一个产品卡片
 *
 * @var  $this yii\web\View
 * @var  $product catalog\models\Product
 */
?>
<div class="product">
    <a class="card" href="<?= Url::to(['/catalog/product/view', 'id' => $product->id ]) ?>">
        <div class="card-img-top">
            <img src="<?= $product->getImageUrl(200) ?>" />
        </div>
        <div class="card-body">
            <div class="name">
                <?= Html::encode($product->title) ?>
            </div>
            <div class="counters d-flex flex-nowrap justify-content-between">
                <div>
                    <i class="fa fa-star-o"></i> 5000
                </div>
                <div>
                    销量 <?= Html::encode($product->salesCount) ?>
                </div>
            </div>
            <div class="prices d-flex flex-nowrap">
                <div price>&yen; <?= $product->market_price ?></div>
                <div old-price>&yen; <?= $product->finalPrice ?></div>
            </div>
        </div>
    </a>
</div>