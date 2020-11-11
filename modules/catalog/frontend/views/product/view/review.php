<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;
use yii\widgets\Pjax;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $product catalog\models\Product
 */
?>
<?php Pjax::begin(['id' => 'product_review_pjax']) ?>
<div id="product_review_content">
    <div class="section review-head">
        <div class="section-title">
            <h3>商品评价</h3>
        </div>
        <div class="section-content p-3">
            <div class="d-flex flex-nowrap">
                <div class="review-counter d-flex align-items-center">
                    <div class="text-center flex-grow-1">
                        <span>好评度</span>
                        <span>98%</span>
                    </div>
                </div>
                <div class="review-tags">
                    <a href="#">风格大气 (20)</a>
                    <a href="#">风格大气 (20)</a>
                    <a href="#">风格大气 (20)</a>
                    <a href="#">风格大气 (20)</a>
                    <a href="#">风格大气 (20)</a>
                    <a href="#">风格大气 (20)</a>
                    <a href="#">风格大气 (20)</a>
                </div>
            </div>
        </div>
    </div>
    <div class="section review-filters">
        <div class="section-content">
            <a class="all" href="#">全部评价(+152312)</a>
            <a class="good" href="#">好评(+1002312)</a>
            <a class="middle" href="#">中评(+2312)</a>
            <a class="bad" href="#">差评(+12)</a>
        </div>
    </div>
    <div id="reviews">
    <?php if(!$dataProvider->totalCount): ?>
        抱歉, 此商品暂时没有任何评论
    <?php else: ?>
        <?php foreach($dataProvider->getModels() as $i => $review): ?>
            <div id="review-<?= $i ?>" class="d-flex flex-nowrap py-3 border-bottom">
                <div class="review-left user-column flex-shrink-0" style="width: 140px; ">
                    <div class="review-customer-avatar">
                        <img src="<?= $this->getAssetUrl('img/user.jpg') ?>" />
                    </div>
                    <div class="review-customer-name">
                        <?= $review->customer_nickname ?>
                    </div>
                    <div class="review-score">
                        <?php for($i = 0; $i < 5; $i++): ?>
                            <?php if($i < $review->score): ?>
                                <i class="fa fa-star text-danger"></i>
                            <?php else: ?>
                                <i class="fa fa-star-o"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>                    
                </div>
                <div class="review-column flex-grow-1 d-flex flex-column">
                    <div class="review-content py-2 flex-grow-1">
                        <?= $review->content ?>
                        <div class="review-images">
                            
                        </div>
                    </div>
                    <div class="review-product-sku text-secondary">
                        <span><?= $review->product_sku ?></span>
                        <span class="ml-3"><?= Yii::$app->formatter->asDatetime($review->created_at)?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="link-pager p-3">
            <?= LinkPager::widget([
                'id' => 'review_link_pager',
                'options' => [
                    'class' => 'review-link-pager',
                ],
                'pagination' => $dataProvider->pagination,
            ])?>
        </div>
    <?php endif; ?>
    </div>
</div>
<?php Pjax::end() ?>

