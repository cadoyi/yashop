<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Breadcrumbs;
?>
<?php 
/**
 * 主要的 layout 文件
 * 
 * @var  $this yii\web\View
 *
 */
?>
<?php $this->beginContent(__DIR__ . '/base.php') ?>
<div class="layout">
    <?= $this->render('main/header') ?>
    <?= $this->render('main/sidebar') ?>
    <main class="layout-body">
        <div class="layout-body-container">
             <?= $content ?>
        </div>
    </main>
    <?= $this->render('main/footer') ?>      
</div>
<?php $this->endContent() ?>