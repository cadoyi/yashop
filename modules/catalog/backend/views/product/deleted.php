<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * 列出产品
 * @var  $this yii\web\View
 * @var  $filterModel catalog\models\fitlers\ProductFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Manage deleted products');
?>
管理被删除的产品