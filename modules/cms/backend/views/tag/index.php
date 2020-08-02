<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $self cando\web\ViewModel
 * @var  $dataProvider yii\data\ActiveDataProvider
 * @var  $filterModel cms\models\filters\TagFilter
 * 
 */
$this->title = Yii::t('app', 'Manage article tags');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add tag'), ['create'], [
        'class' => 'btn btn-sm btn-primary',
    ])?>
</div>
<?= GridView::widget([
    'id'           => 'cms_tag_grid',
    'dataProvider' => $dataProvider,
    'filterModel'  => $filterModel,
    'columns'   => [
        'id',
        'name',
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{update} {delete}',
        ],
    ],
]) ?>