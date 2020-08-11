<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\HomeAsset;
use frontend\assets\SwiperAsset;
use catalog\widgets\CategoryMenu;
SwiperAsset::register($this);
HomeAsset::register($this);

?>
<?php
/**
 * 首页
 * 
 * @var  $this yii\web\View
 * 
 */
?>
<div class="index-container">
    <div menu-and-banner class="d-flex mab">
         <div class="b-menu flex-grow-1 bg-dark text-white" style="width: 200px;min-width: 200px;">

             <?= CategoryMenu::widget(['id' => 'home_menu']) ?>

         </div>
         <div class="banners flex-grow-1 overflow-hidden">
             <div class="swiper-container">
                <div class="swiper-wrapper">
                    <a class="swiper-slide" href="#">
                        <img class="mw-100" src="<?= $this->getAssetUrl('img/temp/b1.jpg')?>" />
                    </a>
                    <a class="swiper-slide" href="#">
                        <img class="mw-100" src="<?= $this->getAssetUrl('img/temp/b2.jpg')?>" />
                    </a>
                </div>
                <div class="swiper-pagination"></div>
             </div>
         </div>
    </div>    

</div>