<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * 这是前端的主要布局文件,适合大多数页面.
 * 
 * @var  $this yii\web\View
 *
 * 
 */
?>
<?php $this->beginContent(__DIR__ . '/base.php') ?>
  <?= $this->render('main/header') ?>
  <main class="container-fluid content">
      <?= $content ?>
  </main>
  <?= $this->render('main/footer') ?>
<?php $this->endContent() ?>