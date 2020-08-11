<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel front\models\filters\MenuFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('app', 'Manage menus');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add menu'), ['create'], [
        'class' => 'btn btn-sm btn-primary',
    ])?>
</div>
<?= GridView::widget([
   'id' => 'front_menu_grid',
   'filterModel' => $filterModel,
   'dataProvider' => $dataProvider,
   'columns' => [
       'id',
       'name',
       'code',
       [
           'class' =>ActionColumn::class,
           'header' => Yii::t('app', 'Action'),
           'template' => '{items} {update} {delete}',
           'buttons' => [
              'items' => function($action, $model, $key) {
                  return Html::a(Yii::t('app', 'Manage menu items'), ['/front/menu-item/index', 'menu_id' => $key], [
                      'class' => 'grid-link',
                  ]);
              }
           ],
       ],
   ],
]) ?>