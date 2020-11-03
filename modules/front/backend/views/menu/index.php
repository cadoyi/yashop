<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
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
        'class' => 'btn btn-sm btn-molv',
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
              'items' => function($url, $model, $key, $action) {
                   $title = Yii::t('app', 'Manage menu items');
                   $url = ['/front/menu-item/index', 'menu_id' => $key];
                   return $action->createButton($title, $url);
              }
           ],
       ],
   ],
]) ?>