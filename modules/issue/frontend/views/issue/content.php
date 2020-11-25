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
 * @var  $content issue\models\Content
 * 
 */
$menu = $content->menu;
?>
<?php $this->beginContent(__DIR__ . '/_layout.php') ?>
    <div class="issue-content-head">
        <ul class="issue-breadcrumbs">
            <li><?= Html::encode($menu->parent->title) ?></li>
            <li><a href="<?= Url::to(['/issue/issue/menu', 'id' => $menu->id ])?>"><?= Html::encode($menu->title) ?></a></li>
        </ul>
    </div>
    <div class="issue-content-body">
        <div class="icc-title">
            <h1><?= Html::encode($content->title) ?></h1>
        </div>
        <div class="icc-content">
            <?= $content->content ?>
        </div>
    </div>
<?php $this->endContent() ?>