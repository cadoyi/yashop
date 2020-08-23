<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\customer\account\LoginAsset;


LoginAsset::register($this);
?>
<?php 
/**
 * @var  $this yii\web\View
 *
 * 
 */
?>
<?php $this->beginContent('@frontend/views/layouts/base.php') ?>
    <header class="login-header d-flex align-items-center">
        <a class="logo" href="<?= Yii::$app->homeUrl ?>">
            <img src="<?= $this->getAssetUrl('img/yashop.png')?>" />
        </a>
        <div class="login-title">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <a class="ml-auto text-dark" href="<?= Yii::$app->homeUrl?>">
            <?= Yii::t('app', 'Home page') ?>
        </a>
    </header>
    <main class="login-content">
         <?= $content ?>
    </main>
    <div class="login-footer text-white bg-dark p-5 text-center">
        <a class="text-white" href="#">
            版权所有
        </a>
    </div>
<?php $this->endContent() ?>