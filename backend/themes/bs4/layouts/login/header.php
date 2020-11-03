<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * login header
 *
 * @var  $this yii\web\View
 */
?>
<header class="login-header">
    <nav class="navbar">
        <a class="navbar-brand" href="<?= Url::to('') ?>">
            <?= Html::encode(Yii::$app->name) ?>
        </a>
    </nav>
</header>