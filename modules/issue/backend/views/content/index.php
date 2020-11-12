<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
use yii\widgets\Pjax;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $menu issue\models\Menu
 * @var  $filterModel issue\models\filters\ContentFilter
 * @var  $dataProvider yii\data\ActiveDataProvier
 */
$category = $menu->category;
$this->addBreadcrumb($category->title, ['/issue/category/index']);
$this->addBreadcrumb($menu->title, ['/issue/menu/index', 'c' => $category->id]);
$this->title = '问题列表';
?>

<div class="grid-buttons">
    <?= Html::a('新增问题', ['create', 'mid' => $menu->id], [
        'class' => 'btn btn-sm btn-molv',
    ])?>
</div>
<?= GridView::widget([
    'id' => 'issue_content_grid',
    //'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        [
            'class' => ActionColumn::class,
            'urlCreator' => function($action, $model, $key) use ($menu) {
                return ['/issue/content/' . $action, 'mid' => $menu->id, 'id' => $key];
            }
        ],
    ],
]) ?>
