<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $type catalog\models\Type
 * @var  $filterModel catalog\models\filters\TypeAttributeFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('app', 'Manage product type attributes');
$this->addBreadcrumb(Yii::t('app', 'Manage product types'), ['/catalog/type/index']);
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new attribute'), ['create', 'type_id' => $type->id ], [
        'class' => 'btn btn-sm btn-molv',
    ])?>
</div>
<?= GridView::widget([
    'id' => 'catalog_typeattribute_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'type_id' => [
            'attribute' => 'type_id',
            'value' => function($model) use ($type) {
                 return $type->name;
            }
        ],
        'name',
        [
            'class'  => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{update} {delete}',
        ],
    ],
])?>