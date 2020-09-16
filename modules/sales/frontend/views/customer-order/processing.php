<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel sales\models\filters\OrderFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = '已支付订单';
$orders = $dataProvider->getModels();
?>
<table class="table table-bordered">
<?php foreach($orders as $order): ?>
   <tr>
       <td>
            <div class="d-flex">
                <div class="order-date"> 
                    <?= Html::encode($order->asDate('created_at')) ?>        
                </div>
                <div class="order-no ml-2">
                    订单号 # <?= Html::encode($order->increment_id) ?>
                </div>
                <div class="order-store ml-3">
                    <?= Html::encode($order->store->name) ?>
                </div>
            </div>
        </td>
   </tr>

   <?php foreach($order->items as $item): ?>
        <?php $product = $item->orderProduct ?>
        <tr>
            <td>
                <img src="<?= $product->getImageUrl(90) ?>" />
            </td>
        </tr>
   <?php endforeach; ?>
   </tr>
<?php endforeach; ?>
</table>
