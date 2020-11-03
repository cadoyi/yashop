<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel  cms\models\filters\CategoryFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('app', 'Manage article categories');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new category'), ['create'], [
        'class' => 'btn btn-sm btn-molv',
    ]) ?>
</div>
<?= GridView::widget([
    'id' => 'cms_category_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{update} {delete}',
        ],
    ],
]) ?>