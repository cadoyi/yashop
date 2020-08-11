<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $menu front\models\Menu
 * @var  $filterModel front\models\filter\MenuItemFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('app', 'Manage menu items');
$this->addBreadcrumb(Yii::t('app', 'Manage menus'), ['/front/menu/index']);
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add menu item'), 
         ['create', 'menu_id' => $menu->id],
         ['class' => 'btn btn-sm btn-primary']
     )?>
</div>
<?= GridView::widget([
    'id' => 'front_menu_item_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
       'id',
       'parent_id',
       'label',
       [
           'class' => ActionColumn::class,
           'template' => '{update} {delete}',
       ],
    ],
]) ?>