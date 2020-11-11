<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * 产品 gallery
 * 
 * @var  $this yii\web\View
 * @var  $product catalog\models\Product
 * 
 */
?>
<div class="banner">
    <div class="swiper-container">
        <div class="swiper-wrapper">
        <?php foreach($product->galleries as $gallery): ?>
             <span class="swiper-slide">
                 <img src="<?= $gallery->getImageUrl(400) ?>" >
             </span>
        <?php endforeach; ?>
        </div>
    </div>
</div>