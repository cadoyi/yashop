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
 <header class="main-header d-flex">
    <div class="sidebar-toggle">
        <a toggle-sidebar title="toggle" href="#">
            <i class="fa fa-navicon"></i>
        </a>
    </div>
    <?= Breadcrumbs::widget([
        'id'    => 'breadcrumbs', 
        'links' => $this->getBreadcrumbs(),
    ])?>
    <div class="header-right d-flex flex-grow-1">
        <nav class="nav navbar-nav">
            <ul class="list-unstyled d-flex">
                <li>
                    <a href="#">
                        <i class="fa fa-envelope-o"></i>
                    </a>
                </li>
                <li>
                    <a class="avatar-link dropdown-toggle d-flex" data-toggle="dropdown" href="#">
                        <?php if($identity): ?>
                        <span class="avatar-span">
                            <?php if($url = $identity->getAvatarUrl()): ?>
                                <img src="<?= $url ?>" />
                            <?php else: ?>
                                <img src="<?= $this->getAssetUrl('img/user.jpg') ?>" />
                            <?php endif; ?>
                        </span>
                        <span>
                            <?= Html::encode($identity->nickname) ?>
                        </span>
                    <?php endif; ?>
                        
                    </a>
                    <ul class="dropdown-menu">
                        <li>user-header</li>
                        <li>user-body</li>
                        <li>
                            <div class="actions">
                                <a href="#">资料</a>
                                <a href="<?= Url::to(['/admin/account/logout'])?>"
                                   data-method="post"

                                >注销</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a title="<?= Yii::t('app', 'Website config') ?>" 
                       href="<?= Url::to(['/core/config/edit'])?>"
                    >
                        <i class="fa fa-cog"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>