<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
use catalog\models\CategoryAttribute;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $category catalog\models\Category
 * @var  $filterModel catalog\models\filters\CategoryAttributeFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */

$this->addBreadcrumb($category->title, ['/catalog/category/index']);
$this->title = '管理分类属性';
?>
<div class="grid-buttons">
    <?= Html::a('新增属性', ['create', 'cid' => $category->id], [
        'class' => 'btn btn-sm btn-molv',
    ]) ?>
</div>
<?= GridView::widget([
     'id' => 'catalog_category_attribute_grid',
     'filterModel'  => $filterModel,
     'dataProvider' => $dataProvider,
     'columns' => [
         'id',
         'category_id' => [
             'attribute' => 'category_id',
             'header' => '分类',
             'filter' => false,
             'value' => function($model) use ($category) {
                  return $category->title;
             }
         ],
         'name',
         'input_type' => [
             'attribute' => 'input_type',
             'filter'    => CategoryAttribute::inputTypeHashOptions(),
             'value'  => function($model, $key, $index, $column){
                 $options = $model->config->inputTypeHashOptions;
                 return $options[$model->input_type];
             },
         ],
         [
             'class' => ActionColumn::class,
         ],
     ],

]) ?>