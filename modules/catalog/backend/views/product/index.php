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
$this->title = Yii::t('app', 'Manage products');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new product'), ['create'], ['class' => 'btn btn-sm btn-primary'])?>
</div>
<?= GridView::widget([
    'id' => 'catalog_product_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        'sku',
        'on_sale:boolean',
        [
            'class'    => ActionColumn::class,
            'header'   => Yii::t('app', 'Action'),
            'template' => '{update} {delete}',
        ],
    ],
])?>