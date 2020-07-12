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
 * @var  $model customer\models\CustomerGroup
 *
 * 
 */
$this->title = Yii::t('app', 'Customer group');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new customer group'), ['create'], [
        'class' => 'btn btn-sm btn-primary',
    ])?>
</div>
<?= GridView::widget([
    'id' => 'customer_group_grid',
    'dataProvider' => $dataProvider,
    'filterModel'  => $filterModel,
    'columns' => [
        'id',
        'name',
        'created_at:datetime',
        'updated_at:datetime',
        [
            'class' => ActionColumn::class,
        ],
    ],

]) ?>