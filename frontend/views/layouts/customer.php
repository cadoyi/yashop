<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\CustomerAsset;
CustomerAsset::register($this);
?>
<?php 
/**
 * 客户的个人中心
 * 
 * @var  $this yii\web\View
 * 
 */
?>
<?php $this->beginContent(__DIR__ . '/base.php') ?>
  <?= $this->render('customer/header') ?>
  <main class="container-fluid content">
      <?= $this->render('customer/sidebar') ?>
      <div class="content-container">
         <div class="content-wrapper">
            <?= $content ?>
         </div>
      </div>
  </main>
  <?= $this->render('customer/footer') ?>
<?php $this->endContent() ?>