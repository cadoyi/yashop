<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel catalog\models\filters\BrandFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Manage brands');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new brand'), ['create'], [
         'class' => 'btn btn-sm btn-molv',
    ])?>
</div>
<?= GridView::widget([
    'id' => 'catalog_brand_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        'sort_order',
        'logo' => [
            'attribute' => 'logo',
            'format'    => 'raw',
            'value' => function($model, $key, $index, $column) {
                if($model->logo) {
                    //return Html::img($model->logoUrl);
                }
                return null;
            }
        ],
        [
            'class'  => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{update} {delete}',
        ],
    ],
])?>