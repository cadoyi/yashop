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
?>
<?php $this->beginScript() ?>
<script>
    var po = new ProductOption(<?= Json::encode([
    'price'         => $product->finalPrice,
    'optionsLength' => count($product->options),
]) ?>, <?= Json::encode($product->options) ?>, <?= Json::encode($product->skusData) ?>);
</script>
<?php $this->endScript() ?>
<table class="table product-desc-table">
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
                 <span style="color: #fd5151; font-size: 1.2rem;">&yen; <?= $product->finalPrice ?></span>
                 <span class="small">&nbsp; <del>&yen; <?= $product->market_price ?></del></span>                                
            </td>
        </tr>
        <?php if(!$product->is_virtual): ?>
             <tr class="product-weight">
                 <td>重 量</td>
                 <td>
                  <div class="weight-value">
                       <span><?= $product->weight ?>g</span>
                  </div>                         
                 </td>
             </tr>
         <?php endif; ?>
        <?php if($product->options): ?>
            <?php foreach($product->options as $i => $option): ?>
                <tr class="product-options">
                     <td><?= Html::encode($option['name']) ?></td>
                     <td>
                         <?php foreach($option['values'] as $value): ?>
                            <label>
                            <input  product-option="<?= $i ?>" 
                                    type="radio" 
                                    name="<?= html::encode($option['name']) ?>"
                                    value="<?= Html::encode($value) ?>" 
                            />
                                <?= Html::encode($value) ?>
                            </label>
                         <?php endforeach; ?>
                     </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <tr class="product-qty">
            <td>数 量</td>
            <?php if($hasStock): ?>
            <td>
                <div class="qty-value input-group input-group-sm">
                    <div class="input-group-prepend">
                         <a sub-qty class="input-group-text rounded-0" href="#">-</a>
                    </div>                                       
                    <input type="number" class="form-control" name="qty" value="1" min="1" max="<?= $product->stock ?>" onchange="changePrice()"/>
                    <div class="input-group-append">
                       <a add-qty class="input-group-text rounded-0" href="#">+</a>
                    </div>
                </div>                        
            </td>
            <?php else: ?>
                <td>已售罄</td>
            <?php endif; ?>
        </tr>
        <tr class="product-cart-actions">
            <td colspan="2">
                <form action="<?= Url::to(['/checkout/cart/add', 'product_id' => (string) $product->id])?>" method="post">
                    <select class="d-none" name="product_sku">
                        <option value=""></option>
                <?php foreach($product->skuModels as $sku): ?>
                    <option value="<?= Html::encode($sku->sku) ?>">
                        <?= Html::encode($sku->sku) ?>
                    </option>
                <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="qty" value="1" />
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
                </form>              
            </td>
        </tr>
    </tbody>
</table>
<script>
    function changePrice() {
        console.log('计算价格');
    }
</script>