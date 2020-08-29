<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $wishlist wishlist\models\Wishlist
 * @var  $filterModel wishlist\models\filters\WishlistItemFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Wishlist');
?>
<div class="wishlist py-3">
    <?= GridView::widget([
        'id' => 'wishlist_items',
        'dataProvider' => $dataProvider,
        'columns' => [
            'product_id' => [
                 'attribute' => 'product_id',
                 'format' => 'raw',
                 'header' => '产品图',
                 'value' => function($item, $key, $index, $column) {
                     $product = $item->product;
                     if(!$product) {
                         return '产品已失效!';
                     }
                     $url = ['/catalog/product/view', 'id' => (string) $product->id];
                     $image = Html::img($product->getImageUrl(90));
                     return Html::a($image, $url);
                 }
            ],
            'product_name' => [
                 'attribute' => 'product_id',
                 'header' => '产品名',
                 'value' => function($item, $key, $index, $column) {
                     $product = $item->product;
                     if(!$product) {
                         return '产品已失效!';
                     }
                     return $product->name;
                 }
            ],
            'product_price' => [
                'attribute' => 'product_id',
                'header' => '产品价格',
                'value' => function($item, $key, $index, $column) {
                     $product = $item->product;
                     if(!$product) {
                         return '产品已失效!';
                     }
                     return '¥ ' . $product->finalPrice;
                }      
            ],
            [
                'class' => ActionColumn::class,
                'header' => '操作',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function($action, $model, $key) {
                        return Html::a('删除', ['/wishlist/wishlist/delete', 'item_id' => $key], [
                            'class' => 'text-danger',
                            'data-confirm' => Yii::t('app', 'Please confirm'),
                            'data-method'  => 'post',
                        ]);
                    }
                ],
            ],
        ],
    ]) ?>
</div>
<style>
    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }
</style>