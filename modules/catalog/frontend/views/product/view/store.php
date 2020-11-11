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
<div class="product-store">
    <div class="store-name">
        <?= $store->name ?>
    </div>
    <div class="store-info">
        <div class="store-user">
            <span>掌柜</span>  
            <span>穿小鞋的公子</span>
        </div>
        <div class="store-i">
            <span>信用</span>
            <span>1000</span>
        </div>    
        <div class="store-service">
            <div>
                <span>描述</span>
                <span>5.0</span>
            </div>
            <div>
                <span>服务</span>
                <span>5.0</span>
            </div>
            <div>
                <span>物流</span>
                <span>5.0</span>
            </div>
        </div>            
    </div>
    <div class="store-buttons">
        <button class="btn btn-sm btn-secondary">进入店铺</button>
        <button class="btn btn-sm btn-outline-secondary">收藏店铺</button>
    </div>
</div>