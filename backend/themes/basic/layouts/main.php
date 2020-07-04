<?php
use yii\bootstrap4\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;
use common\widgets\Menu;
use common\widgets\Alert;
?>
<?php 
/**
 * 主要的 layout 文件
 * 
 * @var  $this yii\web\View
 *
 */
$identity = Yii::$app->user->identity;
?>
<?php $this->beginContent('@backend/themes/basic/layouts/base.php')?>
<div class="main-wrapper container-fluid p-0">       
    <main class="main">
        <?= $this->render('main/sidebar') ?>
        <?= $this->render('main/header') ?>
       
        <div class="main-content">
            <div class="alert-area">
                <?= Alert::widget([
                   'id' => 'app',
                ]) ?>
            </div>
            <?= $content ?>
        </div>
        <?= $this->render('main/footer') ?>         
    </main>        
</div>
   
<?php $this->endContent() ?>