<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel store\models\filters\StoreFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Manage stores');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new store'), ['create'], ['class' => 'btn btn-sm btn-primary'])?>
</div>
<?= GridView::widget([
    'id' => 'store_profile_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        'type',
        'status',
        'phone',
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{update} {delete}',
        ],
    ],
]) ?>
