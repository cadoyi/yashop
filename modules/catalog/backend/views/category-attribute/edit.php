<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $model catalog\models\CategoryAttribute
 * @var  $category catalog\models\Category;
 *
 */


$this->addBreadcrumb($category->title, ['/catalog/category/index']);
$this->addBreadcrumb('管理分类属性', ['index', 'cid' => $category->id ]);
$this->title = '编辑分类属性';
?>
<?php $form = $this->beginForm([
    'id' => 'catalog_category_attribute_form',
]) ?>
    <?= $form->field($model, 'category_id')->dropDownList([
        $category->id => $category->title,
    ], [
        'readonly' => true,
    ]) ?>
    <?= $form->field($model, 'name')->textInput([
        'placeholder' => '请输入属性名称',
    ]) ?>
    <?= $form->field($model, 'input_type')
        ->dropDownList($model->inputTypeHashOptions(), [
           'options' => $model->config->inputTypeDropdownOptions,
        ]) ?>

    <?= $form->field($model, 'json_items')->textarea()->hint('使用 json 格式') ?>

    <?= $form->field($model, 'is_filterable')->dropDownList([
         "0" => '否',
         "1" => "是",
    ]) ?>

    <div class="form-group">
        <?= Html::a('返回', ['index', 'cid' => $category->id], [
            'class' => 'btn btn-sm btn-secondary btn-long',
        ]) ?>
        <?= Html::submitButton('立即保存', [
            'class' => 'btn btn-sm btn-molv',
        ]) ?>
    </div>
<?php $this->endForm() ?>

<?php $this->beginScript() ?>
<script>
    $('#categoryattribute-input_type').on('change', function( e ) {
        var select = $(this);
        var jsonItems = $('#categoryattribute-json_items');
        var jsonItemsContainer = jsonItems.closest('.form-group');
        var value = select.val();
        var option = select.find('option[value="' + value +'"]');
        var hasValue = +option.attr('it-required');
        if(hasValue) {
            var hint = option.attr('it-hint') || '';
            jsonItemsContainer.find('small').text(hint);
            jsonItemsContainer.show();
        } else {
            jsonItemsContainer.hide();
            jsonItems.val('');
        }
    }).trigger('change');
</script>
<?php $this->endScript() ?>