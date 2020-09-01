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
<table class="table product-desc-table">
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
        <tr class="product-tags">
            <td colspan="2">
                <?php if($product->is_new): ?>
                    <span class="badge badge-primary">新品</span>
                <?php endif; ?>
                <?php if($product->is_hot): ?>
                    <span class="badge badge-danger">热销</span>
                <?php endif; ?>
                <?php if($product->is_best): ?>
                    <span class="badge badge-primary">精品</span>
                <?php endif; ?>  
            </td>
        </tr>
        <?php if($product->brand): ?>
        <tr class="product-brand">
            <td>品 牌</td>
            <td><?= Html::encode($product->brand->name) ?></td>
        </tr>
        <?php endif; ?>
        <tr class="product-price">
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
        <?php if(!$product->is_virtual): ?>
             <tr class="product-weight">
                 <td>重 量</td>
                 <td>
                  <div class="weight-value">
                       <span><?= $product->weight ?> <?= Html::encode($product->weight_unit) ?></span>
                  </div>                         
                 </td>
             </tr>
         <?php endif; ?>

        <!-- product option here -->
        <tr class="product-qty">
            <td>数 量</td>
            <?php if($hasStock): ?>
            <td>
                <div class="qty-value input-group input-group-sm">
                    <div class="input-group-prepend">
                         <a sub-qty class="input-group-text rounded-0" href="#">-</a>
                    </div>                                       
                    <input id="qty_input" type="number" class="form-control qty-input" value="1" min="1" max="<?= $product->getMaxStock() ?>"/>
                    <div class="input-group-append">
                       <a add-qty class="input-group-text rounded-0" href="#">+</a>
                    </div>
                </div>                        
            </td>
            <?php else: ?>
                <td>已售罄</td>
            <?php endif; ?>
        </tr>
        <tr>
            <td colspan="2">
                <div class="wishlist-div">
                    <a id="addto_wishlist" 
                        product-id="<?= $product->id ?>"
                        class="wishlist <?= (isset($wishlist) && $wishlist->hasProduct($product)) ? 'active' : ''; ?>" 
                        href="#"
                    >
                        <i class="fa fa-star"></i>
                        <span noadd>加入收藏</span>
                        <span added>已收藏</span>
                    </a>
                </div>
            </td> 
        </tr>
        <tr class="product-cart-actions">
            <td colspan="2">

                <div class="d-flex">
                    <div class="p-3">
                        <button 
                           <?php if(!$hasStock): ?> 
                               disabled="disabled"
                           <?php endif; ?>
                           checkout_button 
                           class="btn btn-primary rounded-0"
                        >
                           立即购买
                       </button>
                    </div>
                    <div class="p-3">
                        <button 
                           <?php if(!$hasStock): ?> 
                               disabled="disabled"
                           <?php endif; ?>
                            tocart_button 
                            class="btn btn-danger rounded-0"
                        >
                           加入购物车
                       </button>
                    </div>
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
            'class' => 'addcart-form',
        ]
    ) ?>
        <select class="d-none" name="product_sku">
            <option value=""></option>
            <?php foreach($product->skus as $sku): ?>
                <option value="<?= Html::encode($sku->id) ?>">
                    <?= Html::encode($sku->sku) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="qty" value="1" />
    <?= Html::endForm() ?>
    <?= Html::beginForm(
        ['/checkout/quote/add-product', 'product_id' => (string) $product->id],
        'post',
        [
            'class' => 'checkout-form',
        ]
) ?>
        <select class="d-none" name="product_sku">
            <option value=""></option>
            <?php foreach($product->skus as $sku): ?>
                <option value="<?= Html::encode($sku->id) ?>">
                    <?= Html::encode($sku->sku) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="qty" value="1" />  
    <?= Html::endForm() ?>
</div>

<?php $this->beginScript() ?>
<script>
    var po = new ProductOption(
        <?= Json::encode($self->getProductInfo()) ?>,
        <?= Json::encode($self->getOptionsData())?>,
        <?= Json::encode($self->getSkusData()) ?>
    );
</script>
<?php $this->endScript() ?> 
