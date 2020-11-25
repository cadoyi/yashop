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
 * @var  $filterModel shop\models\filters\ProductFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = '产品列表';
?>
<div class="grid-buttons">
    <?= Html::a('新增宝贝', ['create'], ['class' => 'btn btn-sm btn-molv']) ?>
</div>
<?= GridView::widget([
    'id' => 'product_index_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        'sku',
        [
            'class' => ActionColumn::class,
        ],
    ],
])?>