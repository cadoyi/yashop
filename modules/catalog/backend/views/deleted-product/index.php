<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<?php 
/**
 * 列出产品
 * @var  $this yii\web\View
 * @var  $filterModel catalog\models\fitlers\ProductFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Manage deleted products');
?>
<?= GridView::widget([
    'id' => 'catalog_product_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        'sku',
        'status:boolean',
        [
            'class'    => ActionColumn::class,
            'header'   => Yii::t('app', 'Action'),
            'template' => '{restore} {delete}',
            'buttons' => [
                'restore' => function($action, $model, $key) {
                    return Html::a('恢复', ['/catalog/deleted-product/restore', 'id' => $key]);
                }
            ],
        ],
    ],
])?>