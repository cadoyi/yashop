<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * account layout header
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
?>
<header class="account-header border-bottom">
    <nav class="navbar">
         <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">Yashop</a>
         <?php if(isset($this->blocks['header'])): ?>
              <?= $this->blocks['header'] ?>
         <?php endif; ?>
    </nav>
</header>