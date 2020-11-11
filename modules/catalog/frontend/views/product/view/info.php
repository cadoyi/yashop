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
                <h5><?= Html::encode($product->name) ?>阿斯蒂芬asd暗示法广芳广芳广芳广芳暗示法广芳广芳广芳</h5>
            </td>
        </tr>
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
        <?php if($product->brand): ?>
        <tr class="product-brand">
            <td>品 牌</td>
            <td><?= Html::encode($product->brand->name) ?></td>
        </tr>
        <?php endif; ?>
        <tr class="product-option">
            <td>颜色</td>
            <td>
                <label>
                    <input type="radio" name="color" value="1" />
                    <span>红色</span>
                </label>
                <label>
                    <input type="radio" name="color" value="1" />
                    <span>蓝色</span>
                </label>
                <label>
                    <input type="radio" name="color" value="1" />
                    <span>灰色</span>
                </label>
                <label>
                    <input type="radio" name="color" value="1" />
                    <span>白色</span>
                </label>
                <label>
                    <input type="radio" name="color" value="1" />
                    <span>红色</span>
                </label>
                <label>
                    <input type="radio" name="color" value="1" />
                    <span>蓝色</span>
                </label>
                <label>
                    <input type="radio" name="color" value="1" />
                    <span>灰色</span>
                </label>
                <label>
                    <input type="radio" name="color" value="1" />
                    <span>白色</span>
                </label>
            </td>
        </tr>
        <tr class="product-option">
            <td>尺寸</td>
            <td>
                <label>
                    <input type="radio" name="size" value="1" />
                    <span>XXL</span>
                </label>
                <label>
                    <input type="radio" name="size" value="1" />
                    <span>XL</span>
                </label>
            </td>
        </tr>
        <!-- product option here -->
        <tr class="product-qty">
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
