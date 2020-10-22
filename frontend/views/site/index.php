<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\HomeAsset;
use frontend\assets\lib\SwiperAsset;
//use catalog\widgets\CategoryMenu;
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
<section class="border-top row flex-nowrap" style="height: 400px;">
    <div class="menus flex-shrink-0" style="height: 400px;width:210px;background: #000;">
        
    </div>
    <div style="width: 780px;">
        <div class="mbs swiper-container">
            <div id="banners" class="banners swiper-wrapper">
                <a class="swiper-slide" href="#">
                    <img height="400" width="780" src="<?= $this->getAssetUrl('img/banner.jpg')?>" />
                </a>
                <a  class="swiper-slide" href="#">
                    <img  height="400" width="780" src="<?= $this->getAssetUrl('img/banner.jpg')?>" />
                </a>
                <a  class="swiper-slide" href="#">
                    <img height="400" width="780" src="<?= $this->getAssetUrl('img/banner.jpg')?>" />
                </a>
                <a  class="swiper-slide" href="#">
                    <img height="400" width="780" src="<?= $this->getAssetUrl('img/banner.jpg')?>" />
                </a>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="phs bg-dark flex-shrink-1 flex-grow-1" style="height: 400px;background: #000;">
        
    </div>
</section>
<section class="row border-top hot-products">
    <div class="col-12">
        <div class=""><h4>精品推荐</h4></div>
        <div class="d-flex flex-wrap">
            <?php for($i =0; $i<12; $i++): ?>
            <div class="product">
                <a class="card" href="#">
                    <div class="card-img-top">
                        <img src="<?= $this->getAssetUrl('img/product.jpg') ?>" />
                    </div>
                    <div class="card-body">
                        <div class="name">
                            产自阿拉伯的西伯利亚大香蕉各种口味 任你挑选大香蕉各种口味 任你挑选
                        </div>
                        <div class="counters d-flex flex-nowrap justify-content-between">
                            <div>
                                <i class="fa fa-star-o"></i> 5000
                            </div>
                            <div>
                                销量 90000
                            </div>
                        </div>
                        <div class="prices d-flex flex-nowrap">
                            <div price>&yen; 3990.00</div>
                            <div old-price>&yen; 4300.00</div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
<section class="row border-top hot-products">
    <div class="col-12">
        <div class=""><h4>热门单品</h4></div>
        <div class="d-flex flex-wrap">
            <?php for($i =0; $i< 12; $i++): ?>
            <div class="product">
                <a class="card" href="#">
                    <div class="card-img-top">
                        <img src="<?= $this->getAssetUrl('img/product.jpg') ?>" />
                    </div>
                    <div class="card-body">
                        <div class="name">
                            产自阿拉伯的西伯利亚大香蕉各种口味 任你挑选大香蕉各种口味 任你挑选
                        </div>
                        <div class="counters d-flex flex-nowrap justify-content-between">
                            <div>
                                <i class="fa fa-star-o"></i> 5000
                            </div>
                            <div>
                                销量 90000
                            </div>
                        </div>
                        <div class="prices d-flex flex-nowrap">
                            <div price>&yen; 3990.00</div>
                            <div old-price>&yen; 4300.00</div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<?php /*
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

</div> */ ?>