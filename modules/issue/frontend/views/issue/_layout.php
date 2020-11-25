<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\basic\issue\IssueAsset;
IssueAsset::register($this);
use issue\frontend\widgets\Menu;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * 
 */
?>
<div class="issue-container">
    <div class="search-top">
        <ul class="search-top-nav nav">
              <li class="nav-item mr-auto">
                    <a class="title nav-link" href="javascript:void(0);">
                        <h1>帮助中心</h1>
                    </a>
              </li>
              <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/issue/issue/index'])?>">帮助首页</a>
              </li>
        </ul>
    </div>
    <div class="search-box d-flex justify-content-center">
        <?= Html::beginForm(['/issue/issue/search'], 'get', [
            'id'     => 'issue_search_form',
           'class'  => 'search-form form-inline flex-nowrap',
        ]) ?>
            <input type="hidden" name="c" value="customer" />
            <input class="form-control rounded-0" 
                 type="search" 
                 name="q"
                 placeholder="搜索您的问题" 
                 aria-label="Search"
                 value="<?= Html::encode(Yii::$app->request->get('q', '')) ?>"
            >
            
            <?= Html::submitButton('搜索问题', [
              'class' => 'btn btn-molv rounded-0'
            ]) ?>
        <?= Html::endForm() ?>
    </div>
    <div class="issue-wrapper d-flex flex-nowrap">
        <div id="issue_menu" class="issue-menu flex-shrink-0">
            <?= Menu::widget([
                'code' => 'customer',
                'activateParents' => true,
            ]) ?>
        </div>
        <div class="issue-content flex-grow-1">
             <?= $content ?>
        </div>
    </div>
</div>