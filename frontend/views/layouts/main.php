<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Breadcrumbs;
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
<?php $this->beginContent('@frontend/views/layouts/base.php') ?>
  <?= $this->render('main/header') ?>
  <main class="location d-flex flex-nowrap">
     <div class="breadcrumbs-head">当前位置 : </div>
     <div class="flex-grow-1">
          <?= Breadcrumbs::widget([
              'id'    => 'breadcrumbs', 
              'links' => $this->getBreadcrumbs(),
          ])?>
     </div>
  </main>
  <main class="page-content container-fluid p-0">
       <?= $content ?>
  </main>
  <?= $this->render('main/footer') ?>
<?php $this->endContent() ?>