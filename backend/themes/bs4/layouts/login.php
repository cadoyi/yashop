<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\bs4\LoginAsset;
LoginAsset::register($this);
?>
<?php 
/**
 * login layout
 *
 * @var  $this yii\web\View
 */
?>
<?php $this->beginContent(__DIR__ . '/base.php'); ?>
   <?= $this->render('login/header')?>
   <main class="login-body">
       <?= $content ?>
   </main>
   <?= $this->render('login/footer') ?>
<?php $this->endContent() ?>