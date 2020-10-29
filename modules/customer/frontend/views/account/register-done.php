<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;
use frontend\assets\basic\customer\AccountAsset;
AccountAsset::register($this);

?>
<?php 
/**
 * @var  $this yii\web\View
 *
 * 
 */
$this->title = Yii::t('app', 'Register') . ' 注册成功';
?>
<?php $this->beginBlock('header') ?>
    <ul class="nav mr-auto header-left">
        <li class="nav-item">
            <a class="nav-link" 
               href="<?= Url::to(['/customer/account/register'])?>">
                用户注册
            </a>
        </li>
    </ul>
    <ul class="nav header-right">
        <li class="nav-item">
            <a class="nav-link" href="<?= Url::to(['/customer/account/login'])?>">登录</a>
        </li>
    </ul>
<?php $this->endBlock(); ?>
<div class="register register-done">
    <div class="wrapper">
        <div>
            <h1 class="h5">用户注册成功!</h1>
        </div>
        <div class="text-center">
            <div class="wel">
                 恭喜! 您已经成功注册本站!
            </div>
            <div class="reb">
                请记住您的用户名: <b><?= Html::encode($model->username) ?></b>
            </div>
            <div class="wg">
                本页面将在 <span id="downtime" class="downtime"></span> 秒之后跳转到登陆页面, 您也可以 <a id="login_button" href="<?= Url::to(['/customer/account/login'])?>">立即登录</a>
            </div>
        </div>
    </div>
</div>
<?php $this->beginScript() ?>
<script>
    downtime(5, function( t ) {
        $('#downtime').text(t);
        if(t === 0) {
            var link = $('#login_button').get(0).href;
            location.href = link;
            return false;
        }
    });
</script>
<?php $this->endScript() ?>

