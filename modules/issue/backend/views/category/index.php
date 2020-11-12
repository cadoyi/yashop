<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel issue\models\filters\CategoryFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Manage issue categories');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new category'), ['create'], [
         'class' => 'btn btn-sm btn-molv',
    ])?>
</div>
<?= GridView::widget([
    'id' => 'issue_category_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'code',
        'title',
        [
            'class'  => ActionColumn::class,
            'template' => '{menu} {update} {delete}',
            'buttons' => [
                'menu' => function($url, $model, $key, $action) {
                    $url = ['/issue/menu/index', 'c' => $key ];
                    $title = '管理菜单';
                    return $action->createButton($title, $url);
                } 
            ],
        ],
    ],
])?>