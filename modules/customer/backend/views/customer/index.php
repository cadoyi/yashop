<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\widgets\ActiveForm;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel backend\models\customer\filters\CustomerFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('app', 'Manage customers');
?>

<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new customer'), ['create'], [
        'class' => 'btn btn-sm btn-molv',
    ])?>
</div>
<div class="grid-view-header">
    <div class="navbar">
    <ul class="nav">
          <li class="nav-item">
              <a class="nav-link" href="#">本页全选</a>
          </li>          
          <li class="nav-item">
              <a class="nav-link" href="#">本页反选</a>
          </li>        
          <li class="nav-item">
              <a class="nav-link" href="#">全选</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#">反选</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="#">已选中 0 条</a>
          </li>
    </ul>
    <ul class="nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" 
               data-toggle="dropdown" 
               href="#" 
               role="button" 
               aria-haspopup="true" 
               aria-expanded="false"
               title="筛选列"
            >
                <i class="fa fa-columns"></i>
            </a>
            <div class="dropdown-menu">
                <label class="dropdown-item">
                    <input type="checkbox" value="1" /> safdf
                </label>
                <label class="dropdown-item">
                    <input type="checkbox" value="1" /> safdf
                </label>
                <label class="dropdown-item">
                    <input type="checkbox" value="1" /> safdf
                </label>
                <label class="dropdown-item">
                    <input type="checkbox" value="1" /> safdf
                </label>
                <label class="dropdown-item">
                    <input type="checkbox" value="1" /> safdf
                </label>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" 
               data-toggle="dropdown" 
               href="#" 
               role="button" 
               aria-haspopup="true" 
               aria-expanded="false"
               title="导出"
            >
                <i class="fa fa-download"></i>
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">导出为 CSV</a>
              <a class="dropdown-item" href="#">导出为 Excel</a>
            </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#" title="打印">
                  <i class="fa fa-print"></i>
              </a>
          </li>
    </ul>
</div>
</div>
<?= GridView::widget([
    'id' => 'customer_grid',
    'dataProvider' => $dataProvider,
    'filterModel'  => $filterModel,
    'columns' => [
        [
            'class' => CheckboxColumn::class,
        ],
        'id',
        'nickname',
        'phone',
        'email',
        'created_at:datetime',
        [
            'class' => ActionColumn::class,
            'template' => '{address} {update} {delete}',
            'buttons' => [
                'address' => function($url, $model, $key, $action) {
                    $url = ['/customer/address/index', 'cid' => $key];
                    $title = Yii::t('app', 'Manage addresses');
                    return $action->createButton($title, $url, [
                        'class' => 'action-address',
                    ]);
                 }
            ],
        ],
    ],
])?>