<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
?>
<?php 
/**
 * @var  $this yii\web\View
 */
?>
<header class="layout-header">
    <nav class="navbar navbar-expand navbar-light">
      <div class="collapse navbar-collapse show">
        <?= Menu::widget([
            'options' => [
                'class' => 'navbar-nav ml-auto',
            ],
            'itemOptions' => [
                'class' => 'nav-item',
            ],
            'linkTemplate' => '<a class="nav-link" href="{url}">{label}</a>',
            'items' => [
                [
                    'label' => '主页',
                    'url'   => ['/site/index'],
                ],
                [
                    'label' => Yii::$app->user->identity->nickname,
                    'url'   => '#',
                    'options' => [
                         'class' => 'nav-item dropdown',
                    ],
                    'template' => '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="{url}">{label}</a>',
                    'submenuTemplate' => '<ul class="dropdown-menu">{items}</ul>',
                    'items' => [
                        [
                            'options' => [
                                'class' => 'dropdown-item',
                            ],
                            'label' => '编辑资料',
                            'url'   => '#',
                        ],
                        [
                            'options' => [
                                'class' => 'dropdown-item',
                            ],
                            'label' => '退出登录',
                            'url'   => ['/admin/account/logout'],
                            'template' => '<a class="nav-link text-danger" data-method="post" data-confirm="确定要退出登录吗 ?" href="{url}">{label}</a>',
                        ],
                    ],
                ],
                [
                    'label' => '系统配置',
                    'url'   => ['/core/config/edit'],
                ],
            ],
        ])?>
        <?php /*
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
        </ul> */ ?>
      </div>
    </nav>
</header>