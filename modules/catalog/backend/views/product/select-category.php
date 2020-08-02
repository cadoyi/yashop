<?php
use yii\helpers\Html;
use yii\helpers\Url;
use catalog\models\Type;
use catalog\widgets\CategorySelector;
?>
<?php 
/**
 * 选择产品分类
 *
 * @var  $this yii\web\View
 * @var  $category  null| catalog\models\Category
 * @var  $typ null| catalog\models\Type
 */
$this->registerJsVar('product_types', $model->getCategoriesTypes());


$this->title = Yii::t('app', 'Add new product');
$this->addBreadcrumb(Yii::t('app', 'Manage products'), ['index']);
?>
<?php $form = $this->beginForm([
    'id' => 'catalog_product_select_category_form',
    'method' => 'get',
    'action' => Url::to(['create']),
]) ?>
   <div class="form-group">
       <label>选择产品分类</label>
       <?= CategorySelector::widget([
          'id' => 'select_category_id',
          'name' => 'category_id',
          'value' => $model->getCategory() ? $model->getCategory()->id : null,
       ]) ?>
   </div>
   <div class="form-group">
      <label>选择产品类型</label>
      <?= Html::dropDownList('type_id', $model->getType() ? $model->getType()->id : null, [], [
           'class' => 'form-control',
           'id' => 'select_type_id',
      ])?>
   </div>       

    <?= Html::submitButton(Yii::t('app', 'Next step'), [
        'class' => 'btn btn-sm btn-primary',
        'id' => 'submit_button',
    ]) ?>
<?php $this->endForm() ?>
<?php $this->beginScript() ?>
<script>
    var categoryInput = $('#select_category_id');
    var typeInput = $('#select_type_id');
    $('#select_category_id').on('change', function( e ) {
       var id = $(this).val();
       var types = product_types[id];
       if(types) {
          var requireUpdate = true;
          $.each(types, function(k, v) {
             var option = typeInput.find('option[value="' + k +'"]');
             requireUpdate = !option.length;
          });
          if(requireUpdate) {
             typeInput.find('option').remove();
             typeInput.append($('<option>', {value: ""}).text('请选择。。。'));
             $.each(types, function(k,v) {
                 var option = $('<option>', { value: k});
                 option.text(v);
                 typeInput.append(option);
             });
          }
       } else {
           typeInput.find('option').remove()
       }
    }).trigger('change');
</script>
<?php $this->endScript() ?>