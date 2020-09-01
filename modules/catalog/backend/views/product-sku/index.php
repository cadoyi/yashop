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
 * @var  $product catalog\models\Product
 * @var  $filterModel catalog\models\filters\ProductSkuFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = '管理 SKU';
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add SKU'), ['create', 'pid' => $product->id], [
         'class' => 'btn btn-sm btn-primary',
    ]) ?>
</div>
<?= GridView::widget([
    'filterModel'  => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'product_id' => [
            'attribute' => 'product_id',
            'filter' => false,
            'format' => 'raw',
            'value' => function($model, $key, $index, $column) use ($product) {
                return Html::a($product->name, ['/catalog/product/update', 'id' => $product->id]);
            } 
        ],
        'sku',
        'price',
        'qty',
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{update} {delete}',
            'urlCreator' => function($action, $model, $key, $index, $column) {
                return [$action, 'pid' => $model->product_id, 'id' => $key];
            }
        ],
    ],
]) ?>