<?php 
use backend\assets\basic\LayoutAsset;
LayoutAsset::register($this);
?>
<?php 
/**
 * basic 主题的基本样式
 * @var  $this yii\web\View
 */
?>
<?php $this->beginContent('@backend/themes/default/layouts/base.php') ?>
    <?= $content ?>
<?php $this->endContent() ?>