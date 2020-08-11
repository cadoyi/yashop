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
?>
<div id="product_view" class="product-view border-top pt-3">
    <div class="container-fluid">
        <div class="d-flex">
            <div class="banner" style="width: 400px; height: 400px;">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    <?php foreach($product->galleries as $gallery): ?>
                         <span class="swiper-slide">
                             <img class="w-100" src="<?= Yii::$app->storage->getUrl($gallery) ?>" >
                         </span>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>


            <div class="desc p-3 flex-grow-1">
                <div class="product-name" style="font-size: 1.2rem;">
                    <?= Html::encode($product->name) ?>
                    <div class="product-tags py-2">
                        <?php if($product->is_new): ?>
                            <span class="badge badge-primary">新品</span>
                        <?php endif; ?>
                        <?php if($product->is_hot): ?>
                            <span class="badge badge-danger">热销</span>
                        <?php endif; ?>
                        <?php if($product->is_best): ?>
                            <span class="badge badge-primary">精品</span>
                        <?php endif; ?>
                    </div>                    
                </div>

                <div class="product-price" style="background:#efefef;">
                    <div class="shop_price py-1">
                        <label>售 &nbsp; &nbsp; &nbsp; 价</label>
                        <span style="color: #fd5151; font-size: 1.2rem;">&yen; <?= $product->price ?></span>
                        <span class="small">&nbsp; <del>&yen; <?= $product->market_price ?></del></span>
                    </div>
                </div>
                <?php /*
            <?php if(!empty($product->productOptions)): ?>
                <div class="product-options border-top mt-2 py-3">
                    <?php foreach($product->productOptions as $option): ?>
                    <div class="option d-flex">
                        <div class="option-label px-2">
                            <label><?= Html::encode($option->name) ?></label>
                        </div>
                        <div class="option-value">
                            <?php foreach($option->getValueList() as $i => $value): ?>
                                <div class="option-value-label">
                                    <input id="option_<?= $option->id?>_<?= $i ?>" name="product-option-<?= $option->id ?>" type="radio" value="<?= Html::encode($value) ?>" />
                                    <label for="option_<?= $option->id?>_<?= $i ?>">
                                        <?= Html::encode($value) ?>
                                    </label>
                                </div>
                           <?php endforeach; ?>
                         </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?> */ ?>
            <?php if(!$product->is_virtual): ?>
                 <div class="product-weight d-flex">
                      <div class="weight px-2">
                          <label>重 量</label>
                      </div>
                      <div class="weight-value">
                           <span><?= $product->weight ?>g</span>
                      </div>
                 </div>
             <?php endif; ?>
                <div class="product-qty d-flex">
                    <div class="qty-label px-2">
                        <label>数 &nbsp; &nbsp; &nbsp; 量</label>
                    </div>
                    <div class="qty-value input-group input-group-sm">
                        <div class="input-group-prepend">
                           <a class="input-group-text rounded-0" href="#">+</a>
                        </div>
                        <input type="number" class="form-control" value="1" />
                        <div class="input-group-append">
                            <a class="input-group-text rounded-0" href="#">-</a>
                        </div>
                    </div>
                </div>
                <div class='product-buttons border-top d-flex mt-3'>
                    <div class="p-3">
                        <button class="btn btn-primary rounded-0">立即购买</button>
                    </div>
                    <div class="p-3">
                        <button class="btn btn-danger rounded-0">加入购物车</button>
                    </div>
                </div>
            </div>   <!-- end desc -->
            <div class="border-left border-right p-3" style="width: 200px;">
                店铺信息写在这里
            </div>
        </div> 
    </div> <!-- end container -->

    <div class="product-detail border-top mt-3" style="min-height: 300px;">
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

                    <?= $product->description ?>
                </div>              
                <div id="special" class="tab-pane fade">
                        <table class="table table-hover table-bordered">
                            <?php /*
                        <?php foreach($product->productAttributes as $attribute): ?>
                            <tr>
                                <th style="width: 120px;">
                                    <?= Html::encode($attribute->label) ?> 
                                </th>
                                <td>
                                    <?php if($attribute->isMultiple()): ?>
                                        <ol>
                                        <?php foreach($attribute->getValue() as $value): ?>
                                            <li><?= Html::encode($value) ?></li>
                                        <?php endforeach; ?>
                                            
                                        </ol>
                                    <?php else: ?>
                                         <?= Html::encode($attribute->getValue()) ?>
                                    <?php endif; ?>
                                        
                                </td>
                            </tr>
                        <?php endforeach; ?> */ ?>
                        </table>
                    </div>

                <div id="comments" class="tab-pane fade">
                    产品评论
                </div>
            </div>
            <div class="shengming">
                本店声明: 所有商品信息都来自第三方,和本平台无关.
            </div>
        </div>
    </div>

</div>

