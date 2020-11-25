<?php
use yii\helpers\Html;
use yii\helpers\Url;
use issue\frontend\widgets\Menu;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 */
$this->title = '帮助中心';
?>
<?php $this->beginContent(__DIR__ . '/_layout.php') ?>
    <div class="issue-content-head">
        常见问题
    </div>
    <div class="issue-content-body">
        <?= Menu::widget([
            'options' => [
                'class' => 'content-menu',
            ],
            'code' => 'customer'
        ])?>
    </div>
<?php $this->endContent() ?>