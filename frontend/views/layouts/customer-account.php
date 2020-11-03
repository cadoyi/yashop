<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\customer\CustomerAccountAsset;
CustomerAccountAsset::register($this);
?>
<?php 
/**
 * 客户的个人中心中的账户设置
 * 
 * @var  $this yii\web\View
 * 
 */
?>
<?php $this->beginContent(__DIR__ . '/base.php') ?>
  <?= $this->render('customer-account/header') ?>
  <main class="container-fluid content">
      <?= $this->render('customer-account/sidebar') ?>
      <div class="content-container">
         <div class="content-wrapper">
            <?= $content ?>
         </div>
      </div>
  </main>
  <?= $this->render('customer-account/footer') ?>
<?php $this->endContent() ?>