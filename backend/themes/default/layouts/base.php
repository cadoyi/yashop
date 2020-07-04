<?php 
use yii\bootstrap4\Html;
use yii\helpers\Url;

?>
<?php 
/**
 * 所有 layout 的布局文件
 * 
 * @var  $this yii\web\View
 *
 */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="<?= Url::to('@web/skin/default/img/logo.png') ?>" type="image/png">
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