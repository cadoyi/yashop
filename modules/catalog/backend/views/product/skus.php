<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
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
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add SKU'), ['/catalog/product-sku/create', 'pid' => $product->id], [
         'class' => 'btn btn-sm btn-molv',
    ]) ?>
</div>
<?= GridView::widget([
    'filterModel'  => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'sku',
        'price',
        'qty',
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{update} {delete}',
            'urlCreator' => function($action, $model, $key, $index, $column) {
                return ['/catalog/product-sku/' . $action, 'pid' => $model->product_id, 'id' => $key];
            }
        ],
    ],
]) ?>