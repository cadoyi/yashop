<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $model catalog\backend\models\ProductForm
 * 
 */
$optionsForm = $model->optionsForm;
$formName = $optionsForm->formName();
?>
<template id="option-value-tag-template">
    <div option-value-tag class="option-value-tag">
        <span>{{tag}}</span>
        <a remove-option-value="{{tag}}" href="#">
            <i class="fa fa-remove"></i>
        </a>
    </div>
</template>
<template id="option-wrapper-template">
<div option-wrapper class="product-option d-flex mb-5 border-bottom border-top shadow-sm">
    <input type="hidden" 
        name="<?= $formName?>[{{index}}][id]"
        value="{{id}}"
    />
    <div class="option-name">
        <input class="form-control" 
               type="text" 
               name="<?= $formName ?>[{{index}}][name]" 
               placeholder="选项名"
               value="{{name}}"
        />
    </div>
    <div class="option-values flex-grow-1">
        <select option-value-hidden-input class="d-none" name="<?= $formName ?>[{{index}}][values][]" multiple>
            {{options}}
        </select>
        <div class="option-value-input d-flex">
            <input add-option-value-input
                   class="form-control rounded-0" 
                   placeholder="添加选项值"
            />
            <button add-option-value
                    type="button" 
                    class="btn btn-outline-secondary text-nowrap rounded-0"
            >
                添加
            </button>
        </div>
        <div option-value-tags class="option-value-tags">{{tags}}</div>

    </div>

    <div class="option-sort-order d-flex flex-column justify-content-around">
        <input sort-order-input type="hidden" name="<?= $formName ?>[{{index}}][sort_order]" value="{{sort_order}}"/>
        <button sort-up type="button">
            <i class="fa fa-level-up"></i>
        </button>
        <button sort-down type="button">
            <i class="fa fa-level-down"></i>
        </button>
    </div>             
    <div class="option-remove d-flex align-items-center justify-content-center">
        <a remove-option href="#">
            <i class="fa fa-trash"></i>
        </a>
    </div>
</div>        
</template>


<div id="edit_product_option" class="edit-product-option">
    
    <div id="product_option_wrapper" style="min-height: 100px; max-width: 500px;">
        
    </div>


    <div class="add-button">
        <button add-option type="button" class="btn btn-sm btn-outline-primary">添加选项</button>
        <?php /*
        <button generate-skus
                type="button"
                class="btn btn-sm btn-outline-secondary"
        >
           生成子产品
        </button> */ ?>
    </div>
    <?php /*
    <div sku-container class="skus mt-3" >
        <table sku-table class="table table-hover table-striped sku-table">
            <thead>
                <tr>
                    <th>图片</th>
                    <th>SKU</th>
                    <th>价格</th>
                    <th>库存</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody sku-table-body>
               
            </tbody>
        </table>
    </div> */ ?>
</div>
<style>
    [sku-table] .preview img {
        width: 36px;
    }
</style>
<?php $this->beginScript() ?>
<script>
    var ProductOption = function(options) {
        this.optionWrapper = $('#product_option_wrapper');
        this.index = 0;
        this.init();
        this.restore(options);
    };
    ProductOption.prototype = {
        init: function() {
            var self = this;
            $('[add-option]').on('click', function( e ) {
                stopEvent(e);
                self.addOption(e);
            });
        },
        restore: function( options ) {
            var self = this;
            options = options || [];
            $.each(options, function() {
                self._addOption(this);
            });
        },
        addOption: function( e ) {
            var self = this;
            var options = this.optionWrapper.find('[option-wrapper]');
            if(options.length >= 3) {
                 alert('最多可添加 3 个选项');
                 return;
            }
            var option = this._addOption();
        },
        _addOption: function( data ) {
            var self = this;
            var defaultData = {
                id: "",
                index: self.index++,
                sort_order: self.index,
                name: '',
                values: [],
            };
            data = $.extend(true, {}, defaultData, data);
            var tags = '';
            var options = '';
            var values = data.values;
            $.each(values, function() {
                tags += self._genreateTag(this);
                options += self._generateOption(this);
            });
            data.tags = tags;
            data.options = options;
            var html = $('#option-wrapper-template').html();
            html = html.replace(/{{(.+?)}}/g, function(match, attr) {
                if(typeof data[attr] !== 'undefined') {
                    return data[attr];
                }
                return match;
            });
            var option = $(html);
            $('#product_option_wrapper').append(option);

            option.on('click', '[remove-option-value]', function( e ) {
                stopEvent(e);
                var value = $(this).attr('remove-option-value');
                self.removeOptionValue(option, value);
            }).on('click', '[add-option-value]', function( e ) {
                stopEvent(e);
                var input = option.find('[add-option-value-input]');
                var value = input.val();
                if(!value) return;
                var result = self.addOptionValue(option, value);
                if(result) {
                    input.val('');
                }
            }).on('click', '[remove-option]', function( e ) { // 移除选项
                stopEvent(e);
                if(confirm('删除选项会影响子产品,确定要删除吗? ')) {
                    option.remove();
                }
            }).on('click', '[sort-up]', function( e ) {
                var prev = option.prev('[option-wrapper]');
                while(prev.length > 0) {
                    if(prev.hasClass('d-none')) {
                        prev = prev.prev('[option-wrapper]');
                        continue;
                    }
                    break;
                }
               if(!prev || !prev.length) {
                   return;
               }
               prev.insertAfter(option);
               self.resort();
            }).on('click', '[sort-down]', function( e ) {
                 var next = option.next('[option-wrapper]');
                 while(next.length > 0) {
                    if(next.hasClass('d-none')) {
                        next = next.next('[option-wrapper]');
                        continue;
                    }
                    break;
                 }
                 if(!next || !next.length) {
                    return;
                 }
                 option.insertAfter(next);
                 self.resort();
            });
            return option;
        },
        _genreateTag: function( name ) {
            var html = $('#option-value-tag-template').html();
            return html.replace(/\{\{tag\}\}/g, name);
        },
        _generateOption: function( value ) {
            return '<option value="' + value +'" selected>' + value + '</option>';
        },
        addOptionValue: function( option, value ) {
            var select = option.find('[option-value-hidden-input]');
            if(select.find('option[value="'+ value +'"]').length > 0) {
                alert('选项值重复');
                return false;
            }
            var selectOption = this._generateOption(value);
            select.append(selectOption);
            var tag = this._genreateTag(value);
            option.find('[option-value-tags]').append(tag);
            return true;
        },
        removeOptionValue: function( option, value ) {
            var select = option.find('[option-value-hidden-input]');
            select.find('option[value="'+ value +'"]').remove();
            option.find('[remove-option-value="' + value +'"]')
               .closest('[option-value-tag]')
               .remove();
        },
        resort: function() {
            this.optionWrapper.find('[option-wrapper]').each(function(i, wrapper) {
                var option = $(wrapper);
                var input = option.find('[sort-order-input]');
                input.val(i +1);
            });
        }
    };
    var po = new ProductOption(<?= $optionsForm->getJson() ?>);
    //po.restore([{"name": "颜色", "values": ["红色", "黑色", "蓝色"]}]);
</script>
<?php $this->endScript() ?>