<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * login asset
 *
 * @var  $this yii\web\View
 */
?>
<?php $this->beginContent(__DIR__ . '/base.php') ?>
    <div class="layui-layout layui-layout-admin">
         <div class="layui-header">
            <div class="layui-logo text-light">
                <?= Html::encode(Yii::$app->name) ?>    
            </div>
         </div>
         <div class="layui-body" style="left:0;">
             <?= $content ?>
         </div>
         <div class="layui-footer layui-bg-black text-center" style="left: 0;">
            <a class="text-light" href="http://beian.miit.gov.cn/">
                <?= Yii::$app->config->get('web/footer/icp')?>
            </a>
         </div>
    </div>
<?php $this->endContent() ?>