<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\LayoutAsset;
$layout = LayoutAsset::register($this);
?>
<?php 
/**
 * 这是前端的主要布局文件,适合大多数页面.
 * 
 * @var  $this yii\web\View
 *
 * 
 */
$this->registerSeoMetaTags();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::encode($this->getTitle()) ?></title>
        <?php $this->registerCsrfMetaTags() ?>
        <?php $this->head() ?>
        <script>
            var BASE_SKIN_URL = '<?= $layout->baseUrl ?>';
        </script>
    </head>
    <body>
        <?php $this->beginBody() ?>
             <?= $content ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>