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
         * 点击隐藏或者显示 未启用 的 SKU
         */
        '[inactive-show]': function( e ) {
            var self = $(this);
            var value = self.attr('inactive-show');
            self.attr('inactive-show', value === "0" ? "1" : "0");
            var tbody = optionContainer.find('[sku-table-body]');
            if(value == "1") { //隐藏
                var checked = tbody.find('[sku-is-active-input]').not(':checked');
                checked.each(function() {
                    var tr = $(this).closest('tr');
                    tr.addClass('d-none');
                });
                self.text('显示所有');
            } else { //显示
                self.text('隐藏未启用');
                tbody.find('tr.d-none').removeClass('d-none');
            }
        },

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
                      skuData.push({option_1: value});
                 });     
             } else if( data.length == 2) {
                $.each(data[0].values, function(_1, v1) {
                    $.each(data[1].values, function(_2, v2) {
                        skuData.push({
                            option_1: v1,
                            option_2: v2
                        });
                    });
                });
             } else {
                $.each(data[0].values, function(_1, v1) {
                    $.each(data[1].values, function(_2, v2) {
                        $.each(data[2].values, function(_3, v3) {
                            skuData.push({
                                option_1: v1,
                                option_2: v2,
                                option_3: v3
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
        }
    };


    $.each(clickable, function(selector, callback) {
        optionContainer.on('click', selector, function( e ) {
            stopEvent(e);
            return callback.call(this, e);
        });
    });
    optionContainer.on('change', '[sku-is-active-input]', function( e ) {
        var self = $(this);
        var toggle = optionContainer.find('[inactive-show]');
        var show = toggle.attr('inactive-show') == "0" ? false: true;
        if(show) {
            self.closest('tr').removeClass('d-none');
            return;
        } else {
            if(self.prop('checked')) {
                self.closest('tr').removeClass('d-none');
            } else {
                self.closest('tr').addClass('d-none');
            }
        }
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
    restore: function( datas ) {
        var self = this;
        $.each(datas, function() {
            wrapper = self.add(this);
            if(this['delete']) {
                wrapper.hide();
            }
        });
    },
    /**
     * 添加一个选项. 注意: 不会检查添加了几个选项.
     */
    add: function( data ) {
        var self = this;
        var defaultData = {
            id: '',
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
        var input = wrapper.find('[id-input]');
        if(input.val()) {
            var deleteInput = wrapper.find('[delete-input]');
            deleteInput.val(1);
            wrapper.removeAttr('option-wrapper')
                   .removeClass('d-flex')
                   .addClass('d-none');
        } else {
            wrapper.remove();
        }        
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
            id: '',
            sku: '',
            price: '',
            stock: $('#product-stock').val(),
            image: '',
            option_1: '',
            option_2: '',
            option_3: '',
            is_active: 1,
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
        tbody.append(html);
    },
    _composeOption: function( data ) {
        data.option = data.option_1;
        if(data.option_2) {
            data.option += '-' + data.option_2;
        }
        if(data.option_3) {
            data.option += '-' + data.option_3;
        }      
    },
    generateSkus: function( datas , recheck) {
        var self = this;
        var optionWrapper = $('#edit_product_option');
        var tbody = optionContainer.find('[sku-table-body]');
        tbody.html('');
        $.each(datas, function() {
            self.generateSku(this);
        });
        if(recheck) {
            tbody.find('[sku-is-active-input]').each(function() {
                $(this).trigger('change');
            });
        }
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
    resort: function() {
        optionContainer.find('[option-wrapper]').each(function(i, wrapper) {
            var option = $(wrapper);
            var input = option.find('[sort-order-input]');
            input.val(i +1);
        });
    }

}


/**
 * 多图上传文件
 * 
 */
var uploader = {
    index: 0,
    bindEvents: function() {
        var self = this;
        $('#cado_mfile').on('click', '.remove', function( e ) {
            stopEvent(e);
            $(this).closest('.preview').remove();
            self.sort();
        }).on('click', '.move-right', function( e) {
            stopEvent(e);
            var preview = $(this).closest('.preview');
            var next = preview.next();
            while(next.length) {
                if(next.data('res')) {
                    break;
                }
                next = next.next();
            }
            if(next.length) {
                preview.insertAfter(next);
            }
            self.sort();

        }).on('click', '.move-left', function( e) {
            stopEvent(e);
            var preview = $(this).closest('.preview');
            var prev = preview.prev();
            while(prev.length) {
                if(prev.data('res')) {
                    break;
                }
                prev = prev.prev();
            }
            if(prev.length) {
                prev.insertAfter(preview);
            }
            self.sort();
        }).on('click', function() {
            $('#gallery_files').trigger('click');
        });
    },
    restore: function( data ) {  // 恢复服务器上的原始数据.
        var self = this;
        $('#cado_mfile').children('.preview-area').hide();
        $.each(data, function(i, res) {
            self.restoreData(res);
        });
        $('#gm').val(JSON.stringify(data));
        $('#cado_mfile').children('.preview-area').show();
    },
    restoreData: function( res ) {
        if(!res.file_id) {
            res.file_id = this.generateId();
        }
        this.generatePreview(res.file_id, res.url);
        this.done(res);
    },
    generateId: function() {
        return Date.now() + '_' + this.index++;
    },
    generatePreview: function(id, src) {
        var html = '<div id="preview_'+ id +'" class="preview"><img src="' + src +'" /><div class="progress"><div class="progress-bar" style="width: 15%;"></div></div></div>';
        $('#cado_mfile').children('.preview-area').append(html);     
    },
    preview: function( data ) {
        var self = this;
        $.each(data.files, function(i, file) {
            var reader = new FileReader();
            reader.onload = function( e ) {
                var src = e.target.result;
                var id = self.generateId();
                self.generatePreview(id, src);
                self.send(id, file);
            }
            reader.readAsDataURL(file);
        });
    },
    send: function(id, file) {
        $('#gallery_files').fileupload('add', { 
            files: [file],
            file_id: id,
            formData: [
                { name: 'file_id', value: id },
                { name: 'product_id', value: galleryConfig.product_id }
            ]
        });
    },
    done: function(res, status, jqXHR) {
        if(!res.file_id) {
            return;
        }
        var id = res.file_id;
        var preview = $('#preview_' + id);
        var removeLink = '<a class="remove" href="#"><i class="fa fa-remove"></i></a>';
        var buttons = '<div class="preview-buttons"><a class="move-left" href="#"><i class="fa fa-arrow-left"></i></a><a class="move-right" href="#"><i class=" fa fa-arrow-right"></i></a></div>';

        setTimeout(function() {
            preview.find('.progress').remove();
            preview.append(removeLink);
            preview.append(buttons);
        }, 1000);

        preview.data('res', res);
        uploader.sort();
    },
    sort: function() {
        var wrapper = $('#cado_mfile').children('.preview-area');
        var values = [];
        wrapper.children('.preview').each(function(i) {
            var preview = $(this);
            if(!preview.data('res')) {
                return;
            }
            var res = preview.data('res');
            var value = {
                image: res.image,
                sort_order: i,
                file_id: preview.attr('id').replace('preview_', ''),
            };
            if(res.id) {
                value.id = res.id;
            }
            values.push(value);
        });
        $('#gm').val(JSON.stringify(values));
    }
};


jQuery(function( $ ){
    uploader.bindEvents();

    $('#gallery_files').fileupload({
        url: galleryConfig.uploadUrl,
        autoUpload: true,
        dropZone: $('#cado_mfile'),
        change: function(e, data) {
            uploader.preview(data);
            return false;
        },
        drop: function(e, data) {
            uploader.preview(data);
            return false;
        },
        progress: function(e, data) {
            var id = data.file_id;
            var value = parseInt((data.loaded / data.total) * 10000, 10) / 100;
            $('#preview_' + id).find('.progress-bar').css({
                'width': value
            });
        },
        add: function(e, data) {
            if (e.isDefaultPrevented()) {
                 return false;
            }
            data.process().done(function() {
                data.submit()
                    .done(uploader.done)
                    .fail(function() {
                        var preview = $('#preview_' + data.file_id);
                        preview.remove();
                    });
            });
        }
    });
});