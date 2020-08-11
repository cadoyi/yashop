<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use core\widgets\Uploader;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $product catalog\models\Product
 */
$self->placeholderUrl = Url::to('@web/assets/8c932fbb/placeholder.svg');
$formName = $product->formName();
?>
<template id="option-value-tag-template">
    <div option-value-tag class="option-value-tag">
        <span>{{tag}}</span>
        <a remove-option-value href="#">
            <i class="fa fa-remove"></i>
        </a>
    </div>
</template>
<template id="option-wrapper-template">
<div option-wrapper class="product-option d-flex mb-3 border-bottom border-top">
    <div class="option-name">
        <input class="form-control" 
               type="text" 
               name="<?= $formName ?>[options][{{index}}][name]" 
               placeholder="选项名"
               value="{{name}}"
        />
    </div>
    <div class="option-values flex-grow-1">
        <select option-value-hidden-input class="d-none" name="<?= $formName ?>[options][{{index}}][values][]" multiple>
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

    <div class="option-sort-order d-flex flex-column">
        <input sort-order-input type="hidden" name="<?= $formName ?>[options][{{index}}][sort_order]" value="{{sort_order}}"/>
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
<template id="sku-tr-template">
   <tr>
       <td>
           <input id="sku_image_{{index}}" type="hidden" sku-image-input name="<?= $formName?>[skus][{{index}}][image]" value="{{image}}" />
           <div id="sku_image_{{index}}_container" class="sku-image-container">
               <input type="file" id="sku_image_{{index}}_fileinput" class="d-none" name="file" />
               <label class="previews m-0" for="sku_image_{{index}}_fileinput">
                   <div class="preview">
                       <img src="{{image_url}}" />
                   </div>
               </label>
           </div>
       </td>
       <td>
           <!-- 选项和值 -->
           <div class="skus-option">
               <input option-1 type="hidden" name="<?= $formName?>[skus][{{index}}][{{option_1_name}}]" value="{{option_1}}" />
               <input option-2 type="hidden" name="<?= $formName?>[skus][{{index}}][{{option_2_name}}]" value="{{option_2}}" />
               <input option-3 type="hidden" name="<?= $formName?>[skus][{{index}}][{{option_3_name}}]" value="{{option_3}}" />
               <input skus-sku type="hidden" name="<?= $formName?>[skus][{{index}}][sku]" value="{{sku}}" />
           </div>
            <span sku-input-option="{{sku}}">{{sku}}</span>
       </td>
       <td>
           <!-- price -->
           <input sku-price type="text" name="<?= $formName ?>[skus][{{index}}][price]" value="{{price}}" />
       </td>
       <td>
           <!-- stock -->
           <input sku-stock type="text" name="<?= $formName ?>[skus][{{index}}][stock]" value="{{stock}}" />
       </td>
       <td>
          <a sku-remove class="btn btn-sm btn-danger" href="#">删除</a>
       </td>
   </tr>   
</template>
<div id="edit_product_option" class="edit-product-option">
    
    <div id="product_option_wrapper" style="min-height: 100px; max-width: 500px;">
        
    </div>


    <div class="add-button">
        <button add-option type="button" class="btn btn-sm btn-outline-primary">添加选项</button>
        <button generate-skus
                type="button"
                class="btn btn-sm btn-outline-secondary"
        >
           生成子产品
        </button>
    </div>
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
    </div>
</div>
<style>
    [sku-table] .preview img {
        width: 36px;
    }
</style>
<?php $this->beginScript() ?>
<script>
/**
 * 产品编辑页面逻辑
 *
 * @author  zhangyang zhangyangcado@qq.com
 */
var optionContainer = $('#edit_product_option');
jQuery(function( $ ) {
    
    var tableSelector = 'table.sku-table';

    /**
     * 点击选项触发的动作
     */
    var clickable = {
        /**
         * 移除选项
         */
        '[remove-option]': function( e ) {
            var optionWrapper = $(this).closest('[option-wrapper]');
            ProductOption.remove(optionWrapper);
        },
        /**
         * 添加选项值
         */
        '[add-option-value]': function( e ) {
            var input = $(this).siblings('[add-option-value-input]');
            var optionWrapper = $(this).closest('[option-wrapper]');
            var value = input.val();
            if(!value) return;
            if(!ProductOption.addValue(optionWrapper, value)) {
                return;
            }
            input.val('');
        },
        /**
         * 移除选项
         */
        '[remove-option-value]': function( e ) {
            var optionWrapper = $(this).closest('[option-wrapper]');
            var value = $(this).prev('span').text();
            console.log(value);
            ProductOption.removeValue(optionWrapper, value);
        },
        /**
         * 添加 产品选项.
         */
        '[add-option]': function( e ) {
             var optionWrappers = optionContainer.find('[option-wrapper]');
             if(optionWrappers.length > 2) {
                 alert('您最多能添加 3 个选项');
                 return;
             }
             ProductOption.add();
        },
        /**
         * 生成子产品 / 生成 SKU 
         */
        '[generate-skus]': function( e ) {
             var tbody = optionContainer.find('[sku-table-body]');
             var hasOld = tbody.children('tr').length > 0;
             if(hasOld && !confirm('确定要重新生成 sku 吗?')) {
                 return;
             }
             var messages = {};
             if(!ProductOption.validate( messages )) {
                 alert(messages.error);
                 return;
             }
             var data = ProductOption.getData();
             var skuData = [];
             if(data.length == 1) {
                 $.each(data[0].values, function(_, value) {
                      skuData.push({option_1: value, option_1_name: data[0].name });
                 });     
             } else if( data.length == 2) {
                $.each(data[0].values, function(_1, v1) {
                    $.each(data[1].values, function(_2, v2) {
                        skuData.push({
                            option_1: v1,
                            option_1_name: data[0].name,
                            option_2: v2,
                            option_2_name: data[1].name,
                        });
                    });
                });
             } else {
                $.each(data[0].values, function(_1, v1) {
                    $.each(data[1].values, function(_2, v2) {
                        $.each(data[2].values, function(_3, v3) {
                            skuData.push({
                                option_1: v1,
                                option_1_name: data[0].name,
                                option_2: v2,
                                option_2_name: data[1].name,
                                option_3: v3,
                                option_3_name: data[2].name
                            });
                        });
                    });
                });
             }
             if(hasOld) {
                 ProductOption.regenerateSkus(skuData);
             } else {
                 ProductOption.generateSkus(skuData);
             }
        },
        '[sort-up]': function( e ) {
            var option = $(this).closest('[option-wrapper]');
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
            ProductOption.resort();
             
        },
        '[sort-down]': function( e ) {
             var option = $(this).closest('[option-wrapper]');
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
             ProductOption.resort();
        },
        '[sku-remove]': function( e ) {
             e.preventDefault();
             e.stopPropagation();
             $(this).closest('tr').remove();
        }
    };


    $.each(clickable, function(selector, callback) {
        optionContainer.on('click', selector, function( e ) {
            stopEvent(e);
            return callback.call(this, e);
        });
    });

});

/**
 * 产品选项操作
 */
var ProductOption = {
    index: 0,
    skuindex: 0,
    /**
     * 恢复服务器值
     */
    restoreOptions: function( datas ) {
        var self = this;
        $.each(datas, function() {
            wrapper = self.add(this);
        });
    },
    /**
     * 添加一个选项. 注意: 不会检查添加了几个选项.
     */
    add: function( data ) {
        var self = this;
        var defaultData = {
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
            tags += self.getTag(this);
            options += self.getSelectOption(this);
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
        var optionWrapper = $(html);
        $('#product_option_wrapper').append(optionWrapper);
        return optionWrapper;
    },
    getTag: function( value ) {
        var html = $('#option-value-tag-template').html();
        return html.replace('{{tag}}', value);
    },
    getSelectOption: function( value ) {
        return '<option value="' + value +'" selected>' + value + '</option>';
    },
    /**
     * 移除选项
     */
    remove: function( wrapper ) {
        wrapper.remove();    
    },
    hasValue: function(wrapper, value) {
        var select = wrapper.find('[option-value-hidden-input]');
        return select.find('option[value="'+value+'"]').length > 0;
    },
    /**
     * 添加一个选项值.
     * @param jQuery wrapper  选项容器
     * @param string value  选项值
     */
    addValue: function( wrapper, value ) {
        var select = wrapper.find('[option-value-hidden-input]');
        if(this.hasValue(wrapper, value)) {
            alert('选项值重复');
            return false;
        }
        var option = this.getSelectOption(value);
        select.append(option);
        var tag = this.getTag(value);
        wrapper.find('[option-value-tags]').append(tag);
        return true;
    },
    /**
     * 移除选项值
     */
    removeValue: function(wrapper, value) {
        if(!this.hasValue(wrapper, value)) {
            return false;
        }
        var select = wrapper.find('[option-value-hidden-input]');
        select.find('option[value="'+ value +'"]').remove();
        wrapper.find('[option-value-tag]').each(function() {
            if($(this).first().text().trim() == value) {
                $(this).remove();
                return false;
            }
        });
        return true;
    },
    /**
     * 验证产品选项.
     * 
     * @param  Object messages 存储错误消息
     * @return boolean
     */
    validate: function( messages ) {
        var options = $('#product_option_wrapper').children('[option-wrapper]');
        if(!options.length) {
             messages.error = '请先添加一个选项';
             return false;
        }
        options.each(function() {
            var option = $(this);
            var input = option.find('.option-name > input');
            var name = input.val().trim();
            if(!name) {
                messages.error = '请先设置选项名称';
                return false;
            }
            var select = option.find('[option-value-hidden-input]');
            var selectValue = select.val();
            if(!selectValue || selectValue.length < 1) {
                messages.error = '请至少设置一个选项值';
                return false;
            }
        });
        if(messages.error) {
            return false;
        }
        return true;
    },
    getData: function() {
        var options = $('#product_option_wrapper').children('[option-wrapper]');
        var data = [];
        $.each(options, function(_) {
            var option = $(this);
            var _data = {};
            var input = option.find('.option-name > input');
            _data.name = input.val().trim();
            var select = option.find('[option-value-hidden-input]');
            _data.values = select.val();
            _data.sort_order = _;
            data.push(_data);
        });
        return data;
    },
    generateSku: function( data , template) {
        var defaultData = {
            index: this.skuindex++,
            sku: '',
            price: $('#product-price').val(),
            stock: $('#product-stock').val(),
            image: '',
            'image_url': '/assets/8c932fbb/placeholder.svg',
            option_1: '',
            option_1_name: '',
            option_2: '',
            option_2_name: '',
            option_3: '',
            option_3_name: '',
        }
        data = $.extend(true, defaultData, data);
        data.checked = data.is_active ? 'checked' : '';
        if(data.price === null) {
            data.price = '';
        }
        this._composeOption(data);

        if(!template) {
            template = $('#sku-tr-template').html();
        }
        var html = template.replace(/{{(.+?)}}/g, function(match, attr) {
            if(typeof data[attr] !== 'undefined') {
                return data[attr];
            }
            return match;
        });
        var optionWrapper = $('#edit_product_option');
        var tbody = optionContainer.find('[sku-table-body]');
        var $html = $(html);
        if(!data.option_2_name) {
            $html.find('input[option-2]').remove();
        }
        if(!data.option_3_name) {
            $html.find('input[option-3]').remove();
        }
        tbody.append($html);
    },
    _composeOption: function( data ) {
        data.sku = data.option_1;
        if(data.option_2) {
            data.sku += '-' + data.option_2;
        }
        if(data.option_3) {
            data.sku += '-' + data.option_3;
        }      
    },
    generateSkus: function( datas ) {
        var self = this;
        var optionWrapper = $('#edit_product_option');
        var tbody = optionContainer.find('[sku-table-body]');
        tbody.html('');
        $.each(datas, function() {
            self.generateSku(this);
        });
    },
    regenerateSkus: function( datas ) {
       var self = this;
       var optionWrapper = $('#edit_product_option');
       var tbody = optionContainer.find('[sku-table-body]');
       tbody.children('tr').hide().addClass('pending');
       $.each(datas, function(_, data) {
           self._composeOption(data);
           var span = tbody.find('[sku-input-option="'+ data.option +'"]');
           if(span.length) {
                span.closest('tr').removeClass('pending').show();
                return;
           }
           self.generateSku(data);
       });
       tbody.find('tr.pending').remove();
    },
    restore: function( options, skus ) {
        var self = this;
        self.restoreOptions(options);
        self.restoreSkus(options, skus);
    },
    restoreSkus: function(options, skus) {
        var _options = {};
        $.each(options, function(i, option) {
            var name = option.name;
            var value = 'option_' + (i + 1) + '_name';
            _options[name] = {name: 'option_' + (i + 1), value: value};
        });
        $.each(skus, function(i2, sku) {
            $.each(sku, function(k, v) {
                if(_options[k]) {
                    var o = _options[k];
                    sku[o.name] = v;
                    sku[o.value] = k;
                }
            });
        });
        this.generateSkus(skus);
    },
    resort: function() {
        optionContainer.find('[option-wrapper]').each(function(i, wrapper) {
            var option = $(wrapper);
            var input = option.find('[sort-order-input]');
            input.val(i +1);
        });
    }

}
  
ProductOption.restore(<?= $self->getProductOptionsJson() ?>, <?= $self->getSkusJson() ?>);


$.uploader('[sku-table] .sku-image-container', {
    'url': '<?= Url::to(['/core/file/upload', 'id' => 'catalog/product/images'])?>',
    'views': {
        success: function(file_id, data) {
           this.parent().find('[sku-image-input]').val(data.filename);
        },
        error: function(file_id, message) {
            alert(message);
        },
        remove: function(file_id) {
           this.parent().find('[sku-image-input]').val('');
        },
        placeholder: '<div class="preview"><img src="/assets/8c932fbb/placeholder.svg"></div>',
        previews: <?= $self->getSkuPreviews() ?>
    }
});
</script>
<?php $this->endScript() ?>