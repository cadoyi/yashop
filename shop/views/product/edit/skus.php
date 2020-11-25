<?php
use yii\helpers\Html;
use yii\helpers\Url;
use catalog\models\filters\ProductSkuFilter;
use common\grid\GridView;
use common\grid\ActionColumn;
use core\widgets\pjaxmodal\PjaxModal;
PjaxModal::widget(['id' => 'pjaxmodal']);
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $model catalog\models\forms\ProductEditForm
 * @var  $product catalog\models\Product
 * @var  $form yii\widgets\ActiveForm
 */
$category = $product->category;
$filterModel = new ProductSkuFilter(['product' => $product]);
$dataProvider = $filterModel->search(Yii::$app->request->get());
?>
<div class="grid-buttons">
    <?= Html::a('新增 SKU', ['/product/add-sku', 'pid' => $product->id], [
        'class' => 'btn btn-sm btn-molv',
        'data' => [
            'pjaxmodal' => '#pjaxmodal',
        ],
    ]) ?>
</div>
<?= GridView::widget([
    'id' => 'product_sku_grid',
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'price',
        'qty',
        [
            'class' => ActionColumn::class,
            'urlCreator' => function($action, $model, $key) {
                return ['/product/'.$action . '-sku', 'pid' => $model->product_id, 'id' => $key];
            },
            'buttons' => [
                'update' => function($url, $model, $key) {
                    $label = '更新';
                    return Html::a($label, $url, [
                        'data-pjaxmodal' => '#pjaxmodal',
                        'class' => 'action-update',
                        'aria-role' => 'action',
                    ]);
                }
            ],
        ],
    ],
])?>
