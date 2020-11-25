<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\lib\SwiperAsset;
SwiperAsset::register($this);
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
    <div id="gallery_swiper" class="swiper-container">
        <div class="swiper-wrapper">
            <span class="swiper-slide">
                <img src="<?= $product->getImageUrl(400) ?>">
            </span>
            <?php foreach($product->galleries as $gallery): ?>
                 <span class="swiper-slide">
                     <img src="<?= $gallery->getImageUrl(400) ?>" >
                 </span>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="gallery_thumbs" class="swiper-container">
        <div class="swiper-wrapper">
            <span class="swiper-slide">
                <img src="<?= $product->getImageUrl(80) ?>">
            </span>
            <?php foreach($product->galleries as $gallery): ?>
                 <span class="swiper-slide">
                     <img src="<?= $gallery->getImageUrl(80) ?>" >
                 </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php $this->beginScript() ?>
<script>
    var thumbsSwiper = new Swiper('#gallery_thumbs', {
        spaceBetween: 5,
        slidesPerView: 5,
        watchSlidesVisibility: true,
    });
    var swiper = new Swiper('#gallery_swiper', {
         spaceBetween: 10,
          thumbs: {
            swiper: thumbsSwiper,
          }
    });
</script>
<?php $this->endScript() ?>