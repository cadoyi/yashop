<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * login footer
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
?>
<footer class="login-footer">
    <div class="text-center">
        <a href="//www.beian.miit.gov.cn/">
            <?= Html::encode(Yii::$app->config->get('web/footer/icp')) ?>        
        </a>
    </div>
</footer>