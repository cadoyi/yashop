<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\assets\JsTreeAsset;
use shop\assets\basic\ProductAsset;
JsTreeAsset::register($this);
ProductAsset::register($this);

?>
<?php 
/**
 *
 * @var  $this yii\web\View
 *
 * 
 */
$this->registerJsVar('loadCategoryUrl', Url::to(['load-categories'], true));

$this->title = '新增宝贝 / 选择分类';
$this->addBreadcrumb('产品列表', ['index']);
?>
<div id="product_select_category" class="product-select-category d-flex flex-column">
    <div class="my-3">
        <div class="form-group">
            <label>请选择产品分类</label>
            <div id="category_container" class="category-container mb-3">
            </div>
        </div>
        <div class="form-group">
            <?= Html::beginForm('', 'get') ?>
            <input id="cid_input" type="hidden" name="cid"  value="" />
            <div class="form-group">
                <button 
                    id="confirm_button"
                    type="submit" 
                    class="btn btn-sm btn-molv"
                    disabled="disabled"
                >确认选择</button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>
<?php $this->beginScript() ?>
<script>
    $('#category_container').jstree({
        'core': {
            "check_callback": true,
            "multiple": false,
            'data': {
               'url': loadCategoryUrl,
                'data': function( node ) {
                    return { 'id': node.id };
                }                
            }
        }
    }).on('ready.jstree', function( e ) {
        //$(this).jstree(true).open_all();
    }).on('select_node.jstree', function(e, data) {
        var inst = data.instance;
        var node = data.node;
        if(inst.is_parent(node)) {
            $('#confirm_button').attr('disabled', 'disabled');
            inst.toggle_node(node);
        } else {
            $('#cid_input').val(node.id);
            $('#confirm_button').removeAttr('disabled');
        }
    });
</script>
<?php $this->endScript() ?>