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
$request = Yii::$app->request;
?>
<?php $this->beginContent(__DIR__ . '/_layout.php') ?>
    <div class="issue-content-head">
         您正在搜索 “<?= Html::encode($request->get('q')) ?>” 
    </div>
    <div class="issue-content-body">
        <ul class="menu-list list-unstyled">
            <?php foreach($models as $model): ?>
                 <li>
                     <a href="<?= Url::to(['/issue/issue/content', 'mid' => $model->menu_id, 'id' => $model->id ])?>">
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