<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\AccountAsset;
AccountAsset::register($this);

?>
<?php 
/**
 * @var  $this yii\web\View
 *
 * 
 */
?>
<?php $this->beginContent(__DIR__ . '/base.php') ?>
    <?= $this->render('account/header') ?>
    <main class="content">
         <?= $content ?>
    </main>
    <?= $this->render('account/footer') ?>
<?php $this->endContent() ?>