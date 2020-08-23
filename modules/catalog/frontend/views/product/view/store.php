<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php 
/**
 * 产品店铺
 * 
 * @var  $this yii\web\View
 * @var  $prodcut catalog\models\Product
 * 
 */
$store = $product->store;
?>
<div class="store-name">
    <?= $store->name ?>
</div>
<div class="store-button">
    <button class="btn btn-sm btn-outline-secondary">进入店铺</button>
    <button class="btn btn-sm btn-outline-secondary">关注店铺</button>
</div>