<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * 
 */
?>
<?= Html::beginForm(['/catalogsearch/product/result'], 'get', [
    'id'     => 'catalogsearch_form',
    'class'  => 'search-form form-inline flex-nowrap',
]) ?>
      <input class="form-control rounded-0" 
             type="search" 
             name="q"
             placeholder="<?= Yii::t('app', 'Search')?> ..." 
             aria-label="Search"
      >
      
      <?= Html::submitButton(Yii::t('app', 'Search'), [
          'class' => 'btn btn-outline-secondary rounded-0'
      ]) ?>
<?= Html::endForm() ?>