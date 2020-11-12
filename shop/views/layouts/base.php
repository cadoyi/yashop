<?php
use yii\helpers\Html;
use yii\helpers\Url;
use shop\assets\basic\AssetBundle;
AssetBundle::register($this);
?>
<?php 
/**
 * base asset
 *
 * @var $this yii\web\View
 */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="<?= $this->getAssetUrl('img/logo.png') ?>" type="image/png">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body class="">
  <?php $this->beginBody() ?>
      <?= $content ?>
  <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>