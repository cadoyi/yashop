<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel catalogsearch\models\filters\ProductFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Search {q}\'s result', ['q' => $filterModel->q]);
?>
<div class="catalogsearch-result">
    <div>
        <h5>您正在搜索 "<span><?= Html::encode($filterModel->q) ?></span>"</h5>
    </div>
</div>
<?= $this->render('@catalog/frontend/views/_products/list', [
    'filterModel' => $filterModel,
    'dataProvider'=> $dataProvider,
]) ?> 