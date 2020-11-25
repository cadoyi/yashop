<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $dataProvider yii\data\ActiveDataProvider
 * @var  $tab 对应的连接名称.子页面需要设置.
 * 
 */
?>
<div class="wishlist-container">
    <ul class="nav nav-tabs nav-tabs-brief">
        <li class="nav-item">
            <a class="nav-link <?= isset($tab) && $tab === 'product' ? 'active' : ''; ?>" 
               href="<?= Url::to(['/wishlist/product/index'])?>"
            >
                产品
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= isset($tab) && $tab === 'store' ? 'active' : ''; ?>" 
               href="<?= Url::to(['/wishlist/store/index'])?>"
            >
                店铺
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <?= $content ?>
    </div>
</div>