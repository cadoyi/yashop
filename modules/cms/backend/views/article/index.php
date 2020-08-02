<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel  cms\models\filters\ArticleFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('app', 'Manage articles');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new article'), ['create'], [
        'class' => 'btn btn-sm btn-primary',
    ]) ?>
</div>
<?= GridView::widget([
    'id' => 'cms_article_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        'category_id' => [
            'attribute' => 'category_id',
            'filter' => $self->categoryFilters(),
            'value' => function( $model, $key, $index, $column) use ($self) {
                return $self->getCategoryName($model);
            }
        ],
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{update} {delete}',
        ],
    ],
]) ?>