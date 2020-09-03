<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\catalog\product\ViewAsset;
use frontend\assets\SwiperAsset;
SwiperAsset::register($this);
ViewAsset::register($this);
?>
<?php 
/**
 * 浏览产品
 *
 * @var  $this yii\web\View
 * @var  $product frontend\models\catalog\Product
 * 
 */
$this->title = $product->name;
$viewOptions = [ 'product' => $product, 'self' => $self ];
$reviewOptions = array_merge($viewOptions, ['filterModel' => $filterModel, 'dataProvider' => $dataProvider]);
?>
<div id="product_view" class="product-view border-top pt-3">
    <div class="container-fluid">
        <div class="d-flex">
            <?= $this->render('view/gallery', $viewOptions); ?>

            <div class="desc px-3 pt-0 flex-grow-1">
                <?= $this->render('view/info', $viewOptions) ?>
            </div>   <!-- end desc -->
            <div class="border-left border-right p-3 flex-shrink-0" style="width: 200px;">
                <?= $this->render('view/store', ['product' => $product]) ?>
            </div>
        </div> 
    </div> <!-- end container -->

    <div class="product-detail border-top pt-3" style="min-height: 300px;">
        <div class="container">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#description">
                        产品描述
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#special">
                        规格参数
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#comments">
                        产品评论
                    </a>
                </li>
            </ul>
            <div class="tab-content p-3">
                <div id="description" class="tab-pane fade active show">
                     <?= $this->render('view/description', $viewOptions) ?>
                </div>              
                <div id="special" class="tab-pane fade">
                    <?= $this->render('view/special', $viewOptions) ?>
                </div>
                <div id="comments" class="tab-pane fade">
                    <?= $this->render('view/review', $reviewOptions) ?>
                </div>
            </div>
            <div class="product-note">
                <?= $this->render('view/note', $viewOptions) ?>

            </div>
        </div>
    </div>

</div>

