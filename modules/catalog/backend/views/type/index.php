<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
use catalog\models\widgets\Category;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel catalog\models\filters\TypeFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$categoryHashOptions = Category::hashOptions();


$this->title = Yii::t('app', 'Manage product types'); 
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new product type'), ['create'], [
        'class' => 'btn btn-sm btn-molv',
    ])?>
</div>
<?= GridView::widget([
    'id'           => 'catalog_type_grid',
    'filterModel'  => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        'category_id' => [
            'attribute' => 'category_id',
            'filter'    => $categoryHashOptions,
            'filterInputOptions' => [
                 'class' => 'form-control', 
                 'id' => null,
                 'encodeSpaces' => true,
            ],
            'value'     => function($model, $key, $index, $column) use ($categoryHashOptions) {
                $categoryId = $model->category_id;
                return $categoryHashOptions[$categoryId];
            }
        ],
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{attrs} {update} {delete}',
            'buttons' => [
                'attrs' => function($url, $model, $key, $action) {
                    $title = Yii::t('app', 'Manage attributes');
                    $url = ['/catalog/type-attribute/index', 'type_id' => $key];
                    return $action->createButton($title, $url);
                }
            ],
        ]
    ],
])?>