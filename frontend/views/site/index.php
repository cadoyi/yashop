<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\HomeAsset;
use frontend\assets\lib\SwiperAsset;
//use catalog\widgets\CategoryMenu;
use front\widgets\NavMenu;
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
<section class="row flex-nowrap justify-content-center align-items-center search">
    <form class="child-rounded-0" method="get">
         <div class="form-row">
            <div class="col-auto input-col p-0 ">
                <div class="switch-bar">
                    <a class="active" href="#">搜产品</a>
                    <a href="#">搜店铺</a>
                </div>
                <input class="form-control" 
                       type="search" 
                       name="q"
                       placeholder="请输入您要搜索的产品名" 
                />
            </div>
            <div class="col p-0">
                <button class="btn btn-dlv">搜索产品</button>
            </div>            
         </div>

    </form>
</section>
<section class="home-nav border-top row justify-content-center flex-nowrap" style="min-height: 400px;">
    <div class="home-menus flex-shrink-0">
        <?= NavMenu::widget([
           'options' => [
                'class' => 'menus',
           ],
        ]) ?>
    </div>
    <div style="width: 780px;">
        <div class="mbs swiper-container">
            <div id="banners" class="banners swiper-wrapper">
                <a class="swiper-slide" href="#">
                    <img height="468" width="780" src="<?= $this->getAssetUrl('img/banner.jpg')?>" />
                </a>
                <a  class="swiper-slide" href="#">
                    <img  height="468" width="780" src="<?= $this->getAssetUrl('img/banner.jpg')?>" />
                </a>
                <a  class="swiper-slide" href="#">
                    <img height="468" width="780" src="<?= $this->getAssetUrl('img/banner.jpg')?>" />
                </a>
                <a  class="swiper-slide" href="#">
                    <img height="468" width="780" src="<?= $this->getAssetUrl('img/banner.jpg')?>" />
                </a>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
        
    </div>
</section>
<section class="section product-list best-products">
    <div class="section-title">
        <h3>精品推荐</h3>
    </div>
    <div class="section-content">
        <div class="d-flex flex-wrap">
            <?php for($i =0; $i<5; $i++): ?>
            <?php foreach($self->bestProducts() as $product): ?>
                <?= $this->render('@frontend/views/_common/product', [
                    'product' => $product,
                ]) ?>
            <?php endforeach; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
<section class="section product-list hot-products">
    <div class="section-title">
        <h3>热销单品</h3>
    </div>
    <div class="section-content">
        <div class="d-flex flex-wrap">
            <?php for($i =0; $i<5; $i++): ?>
            <?php foreach($self->hotProducts() as $product): ?>
               <?= $this->render('@frontend/views/_common/product', [
                    'product' => $product,
                ]) ?>
            <?php endforeach; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
<section class="section product-list new-products">
    <div class="section-title">
        <h3>最新单品</h3>
    </div>
    <div class="section-content">
        <div class="d-flex flex-wrap">
            <?php for($i =0; $i<5; $i++): ?>
            <?php foreach($self->hotProducts() as $product): ?>
                <?= $this->render('@frontend/views/_common/product', [
                    'product' => $product,
                ]) ?>
            <?php endforeach; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>