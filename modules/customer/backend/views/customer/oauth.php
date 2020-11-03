<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $customer customer\models\Customer
 * @var  $filterModel customer\models\filters\CustomerOauthFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
?>
<?php $this->beginBlock('content'); ?>
   <?= GridView::widget([
       'id' => 'customer_oauth_grid',
       'dataProvider' => $dataProvider,
       'columns' => [
           'id',
           'type',
           'oauth_id',
           [
               'class' => ActionColumn::class,
               'template' => '{delete}',
               'urlCreator' => function($action, $account, $key) use ($customer){
                    return [
                        'delete-oauth', 
                        'cid' => $customer->id, 
                        'id'  => $key,
                    ];
                }
           ],
       ],
   ])?>
<?php $this->endBlock() ?>
<?php $this->beginContent('@customer/backend/views/customer/_update.php', [
    'key' => $customer->id,
    'itemName' => 'oauth',
]) ?>

<?php $this->endContent() ?>