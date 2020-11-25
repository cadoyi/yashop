<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $product catalog\models\Product
 * 
 */
?>
<div class="d-flex wlinks">
    <a id="add_to_wishlist" 
       href="<?= Url::to(['/wishlist/product/add', 'product_id' => $product->id ])?>"
    >
        <i class="fa fa-star-o"></i> 收藏
    </a>
    <a id="share_it" class="mr-auto" href="#">
        <i class="fa fa-share-alt"></i> 分享
    </a>
    <a id="tip_off" href="#">
        <i class="fa fa-minus-circle"></i> 举报
    </a>
</div>
<?php $this->beginScript() ?>
<script>
    $('#add_to_wishlist').on('click', function( e ) {
        stopEvent(e);
        $.post(this.href, {
            cancel: 0
        }).then(function( res ) {
            if(res.error) {
                op.alert(res.message);
                return;
            }
            op.alert('收藏成功!');
        });
    });
</script>
<?php $this->endScript() ?>