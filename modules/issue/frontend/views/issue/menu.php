<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\LinkPager;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $menu issue\models\Menu
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$models = $dataProvider->getModels();
?>
<?php $this->beginContent(__DIR__ . '/_layout.php') ?>
    <div class="issue-content-head">
        <ul class="issue-breadcrumbs">
            <li><?= Html::encode($menu->parent->title) ?></li>
            <li><?= Html::encode($menu->title) ?></li>
            <li>共 <?= Html::encode($dataProvider->totalCount) ?> 篇</li>
        </ul>
    </div>
    <div class="issue-content-body">
        <ul class="menu-list list-unstyled">
            <?php foreach($models as $model): ?>
                 <li>
                     <a href="<?= Url::to(['/issue/issue/content', 'mid' => $menu->id, 'id' => $model->id ])?>">
                         <?= Html::encode($model->title) ?>
                     </a>
                 </li>
            <?php endforeach; ?>
        </ul>
        <div class="link-pager d-flex justify-content-center">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页',
            ]) ?>
        </div>

    </div>
<?php $this->endContent() ?>