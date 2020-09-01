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
<?php /*
<?php Pjax::begin(['id' => 'product_review_pjax']) ?>
<div id="product_review_content">
    <div id="reviews">
    <?php if(!$dataProvider->totalCount): ?>
        抱歉, 此商品暂时没有任何评论
    <?php else: ?>
        <?php foreach($dataProvider->getModels() as $i => $review): ?>
            <div id="review-<?= $i ?>" class="d-flex flex-nowrap py-3 border-bottom">
                <div class="user-column flex-shrink-0" style="width: 140px; ">
                    <?= $review->customer_nickname ?>
                </div>
                <div class="review-column flex-grow-1">
                    <div class="review-score">
                        <?php for($i = 0; $i < 5; $i++): ?>
                            <?php if($i < $review->score): ?>
                                <i class="fa fa-star text-danger"></i>
                            <?php else: ?>
                                <i class="fa fa-star-o"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <div class="review-content py-2">
                        <?= $review->content ?>
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
                'pagination' => $dataProvider->pagination,
            ])?>
        </div>
    <?php endif; ?>
    </div>
</div>
<?php Pjax::end() ?>

*/ ?>