<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $wishlist wishlist\models\Wishlist
 * @var  $filterModel wishlist\models\filters\WishlistStoreFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Wishlist');
?>
<?php $this->beginContent('@wishlist/frontend/views/common/wishlist.php', [
    'tab' => 'store',
]) ?>
<div id="wishlist-store">
    <h1>wishlist store</h1>
</div>
<?php $this->endContent() ?>