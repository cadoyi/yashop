<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $product catalog\models\Product
 * 
 */
$hasStock = $product->hasStock();
if(!Yii::$app->user->isGuest) {
    $customer = Yii::$app->user->identity;
    $wishlist = $customer->wishlist;
}
$this->registerJsVar('add_wishlist_url', Url::to(['/wishlist/wishlist/add-product']));
$this->registerJsVar('productSkus', $self->getSkusData());
?>
<table class="table product-desc">
    <colgroup>
        <col width="100px" />
        <col />
    </colgroup>
    <tbody>
        <tr class="product-name">
            <td colspan="2">
                <h5><?= Html::encode($product->name) ?></h5>
            </td>
        </tr>
        <tr id="product_price_tr" class="product-price" data-price="<?= $product->finalPrice?>">
            <td>售 价</td>
            <td>
                 <span style="color: #fd5151; font-size: 1rem;">
                    &yen; 
                    <span id="product_price">
                        <?= $product->finalPrice ?>        
                    </span>
                 </span>
                 <span class="small ml-2">
                    <del>
                        &yen;
                        <span id="product_market_price">
                            <?= $product->market_price ?>
                        </span>    
                    </del>
                </span>                                
            </td>
        </tr>
        <?php if($product->brand): ?>
        <tr class="product-brand">
            <td>品 牌</td>
            <td><?= Html::encode($product->brand->name) ?></td>
        </tr>
        <?php endif; ?>

        <!-- product option here -->
        <tr id="product_qty" class="product-qty">
            <td>数 量</td>
            <?php if($hasStock): ?>
            <td>
                <div class="d-flex">
                    <div class="qty-value input-group input-group-sm">
                        <div class="input-group-prepend">
                             <a sub-qty class="input-group-text rounded-0" href="#">-</a>
                        </div>                                       
                        <input id="qty_input" type="number" class="form-control qty-input" value="1" min="1" max="<?= $product->getMaxStock() ?>"/>
                        <div class="input-group-append">
                           <a add-qty class="input-group-text rounded-0" href="#">+</a>
                        </div>
                    </div>
                    <div class="flex-grow-1 qty-note">库存还剩 111111 件</div>
                </div>                     
            </td>
            <?php else: ?>
                <td>已售罄</td>
            <?php endif; ?>
        </tr>
        <tr class="product-cart-actions">
            <td colspan="2">
                <div class="d-flex">
                    <div class="mr-4">
                        <button 
                           <?php if(!$hasStock): ?> 
                               disabled="disabled"
                           <?php endif; ?>
                           checkout_button 
                           class="btn btn-seagreen rounded-0"
                           type="submit"
                           form="checkout_form"
                        >
                           &nbsp;&nbsp;立即购买&nbsp;&nbsp;
                       </button>
                    </div>
                    <div>
                        <button 
                           <?php if(!$hasStock): ?> 
                               disabled="disabled"
                           <?php endif; ?>
                            tocart_button 
                            class="btn btn-molv rounded-0"
                            type="submit"
                            form="addcart_form"
                        >
                           加入购物车
                       </button>
                   </div>
                </div>
           
            </td>
        </tr>
        <tr class="product-promise">
            <td>卖家承诺</td>
            <td>
                <div class="promise">
                    <a href="#">七天无理由</a>
                    <a href="#">极速退款</a>
                    <a href="#">正品保证</a>
                    <a href="#">七天无理由</a>
                    <a href="#">极速退款</a>
                    <a href="#">正品保证</a>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<div class="d-none forms">
    <?= Html::beginForm(
        ['/checkout/cart/add', 'product_id' => $product->id],
        'post',
        [
            'id'    => 'addcart_form',
            'class' => 'addcart-form',
        ]
    ) ?>
        <input type="hidden" name="product_sku" />
        <input type="hidden" name="qty" value="1" />
    <?= Html::endForm() ?>
    <?= Html::beginForm(
        ['/checkout/quote/add-product', 'product_id' => (string) $product->id],
        'post',
        [
            'id'    => 'checkout_form',
            'class' => 'checkout-form',
        ]
) ?>
        <input type="hidden" name="product_sku" />
        <input type="hidden" name="qty" value="1" />  
    <?= Html::endForm() ?>
</div>

<?php $this->beginScript() ?>
<script>
    var po = new ProductOption(
        <?= Json::encode($self->getProductOptionsData()) ?>
    );
    
    $('#addcart_form, #checkout_form').on('submit', function( e ) {
        stopEvent(e);
        var form = $(this);
        var sku = $('#product_view').data('sku');
        if(!sku) {
            op.alert('请选择规格');
            return;
        }
        var qtyInput = form.find('[name="qty"]');
        qtyInput.val($('#qty_input').val());
        form.find('[name="product_sku"]').val(sku.id);
        var data = form.serializeArray();
        var url = form.attr('action');
        $.post(url, data).then(function( res ) {
            if(res.error) {
                op.alert(res.message);
                return;
            }
            op.success('已加入购物车');
        });
    });
</script>
<?php $this->endScript() ?> 
