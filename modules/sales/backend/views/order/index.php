<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
use sales\models\Order;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel sales\models\filters\OrderFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('app', 'Manage orders');
?>
<?= GridView::widget([
    'id' => 'sales_order_gird',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
         'id',
         'increment_id',
         'status' => [
             'attribute' => 'status',
             'filter'   => Order::statusHashOptions(),
             'value' => function($model, $key, $index, $column) {
                  $options = $column->filter;
                  return $options[$model->status];
             }
         ],
         'grand_total',
         'customer_nickname',
         'store_id' => [
             'attribute' => 'store_id',
             'header' => '店铺',
             'value' => function($model, $key, $index, $column) {
                 $store = $model->store;
                 if($store) {
                    return $store->name;
                 }
                 return '店铺已删除';
             }
         ],
         'created_at:datetime',
         [
             'class' => ActionColumn::class,
             'header' => Yii::t('app', 'Action'),
             'template' => '{view}'
         ],
    ],
]) ?>
