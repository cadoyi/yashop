<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $category catalog\models\Category;
 * @var  $filterModel catalog\models\filters\CategoryProductFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */

$this->title = $category->title;
?>
<?= $this->render('@frontend/views/_common/product-list', [
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
]) ?>

