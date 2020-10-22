<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * layui 基本模板
 * 
 * @var  $this yii\web\View
 */
?>
<?php $this->beginContent(__DIR__. '/base.php') ?>
<div class="layui-layout layui-layout-admin">
   <?= $this->render('main/header') ?>
   <?= $this->render('main/sidebar') ?>
    <div id="layui_body" class="layui-body">  
        <?= $content ?>
    </div>
   <?= $this->render('main/footer') ?>
</div>
<?php $this->endContent() ?>
