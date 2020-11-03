<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
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
            'template' => '{restore}',
            'buttons' => [
                'restore' => function($url, $model, $key, $action) {
                    $title = Yii::t('app', 'Restore');
                    $url = ['/catalog/deleted-product/restore', 'id' => $key];
                    return $action->createButton($title, $url, [
                       'data-method' => 'post',
                       'data-confirm' => '确定要恢复吗? ',
                    ]);
                }
            ],
        ],
    ],
])?>