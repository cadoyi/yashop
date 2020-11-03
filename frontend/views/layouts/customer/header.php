<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * customer header
 *
 * @var  $this yii\web\View
 */
?>
<?= $this->render('../main/header') ?>
<nav class="navbar navbar-expand customer-header">
  <a class="navbar-brand" href="<?= Url::to(['/customer/center/dashboard'])?>">个人中心</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto ml-5">
      <li class="nav-item active">
        <a class="nav-link" href="<?= Yii::$app->homeUrl ?>">首页</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/customer/info/index'])?>">账户设置</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          更多设置
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
    <form class="form-inline">
      <input class="form-control" 
             type="search" 
             placeholder="输入关键字搜索" 
             aria-label="Search"
      />
      <button class="btn btn-molv" type="submit">搜索</button>
    </form>
  </div>
</nav>