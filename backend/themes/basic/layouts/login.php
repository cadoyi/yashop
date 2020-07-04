<?php
use yii\bootstrap4\Html;
use yii\helpers\Url;
use backend\assets\basic\LoginAsset;

LoginAsset::register($this);
?>
<?php 
/**
 * 登录页面布局
 * 
 * @var  $this yii\web\View
 *
 */
?>
<?php $this->beginContent('@backend/themes/basic/layouts/base.php')?>

<div class="container-fluid" style="height:100%;">
    <div class="row">
        <div class="login-title w-100">
           <img src="<?= $this->getAssetUrl('img/logo.png') ?>" />
        </div>        
    </div>
    <div class="row login-container flex-column" style="background-image: url(<?= $this->getAssetUrl('img/login-bg.jpg') ?>)">
        <div class="h-100">
            <?= $content ?>
        </div>
    </div>        
    <div class="row login-footer bg-white">
        <div class="w-100 p-3 text-center">
            <p class="mb-0">© 2003-2020 YaShop,Inc.All rights reserved.</p>
        </div>
    </div>
</div>
   
<?php $this->endContent() ?>