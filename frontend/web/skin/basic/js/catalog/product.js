/**
 * 产品页面的 js
 *
 */
var ProductOption = function(options) {
    this.options = options;
    this.render();
};
ProductOption.prototype = {
    render: function() {
        var self = this;
        $.each(this.options, function() {
            self.renderOption(this);   
        });
        var qtyInput = $('#qty_input');
        var max = +qtyInput.attr('max');
        var min = +qtyInput.attr('min');
        qtyInput.on('change', function( e ) {
             self.redraw();
        }).parent().on('click', '[sub-qty]', function( e ) {
            stopEvent(e);
            var qty = +qtyInput.val() - 1;
            qty = qty < min ? min : qty;
            qtyInput.val(qty);
            qtyInput.trigger('change');
        }).on('click', '[add-qty]', function( e ) {
            stopEvent(e);
            var qty = +qtyInput.val() + 1;
            qty = qty > max ? max : qty;
            qtyInput.val(qty);
            qtyInput.trigger('change');
        });
    },
    /**
     * 渲染单个选项
     */
    renderOption: function( option ) {
        var self = this;
        var tr = $('<tr>', {
            'class': 'product-option'
        });
        tr.insertBefore('#product_qty');
        var td = $('<td>');
        td.text(option.label);
        tr.append(td);
        var td2 = $('<td>');
        tr.append(td2);
        $.each(option.options, function(i, _option) {
            var label = $('<label>');
            var input = $('<input>', {
                type: "radio",
                name: option.label,
                value: _option.label
            });
            var span = $('<span>');
            span.text(_option.label);
            label.append(input);
            label.append(span);
            td2.append(label);
            label.data('skus', _option.skus);
            self.bindLabelEvent(label);
        });
    },
    /**
     * 绑定选项中一个标签的点击事件
     */
    bindLabelEvent: function( label ) {
        var self = this;
        label.on('change', '[type="radio"]', function( e ) {
            self.triggerChange();
        });
    },
    /**
     * 触发标签选中事件
     */
    triggerChange: function() {
        var self = this;
        var all = true;
        var inputs = {};
        $('tr.product-option').each(function() {
            var input = $(this).find('input[type="radio"]:checked');
            if(!input.length) {
               all = false;
               return false;
            }
            inputs[input.attr('name')] = input.val();
        });
        if(!all) return;
        var match = false;
        $.each(this.options, function(i, option) {
            $.each(option.options, function(k, op) {
                $.each(op.skus, function(s, sku) {
                    var attrs = sku.attrs;
                    var matchs = true;
                    $.each(inputs, function(name, value) {
                        if(!(name in attrs) || attrs[name] !== value) {
                            matchs = false;
                            return false;
                        }
                    });
                    if(matchs) {
                        match = sku;
                        return false;
                    }
                });
                return !match;
            });
            return !match;
        });
        this.showSkuInfo(match);
    },
    /**
     * 将对应的 SKU 信息同步到页面上。
     */
    showSkuInfo: function( sku ) {
        $('#product_view').data('sku', sku);
        if(!sku) {
            console.log('无货');
        } else {
            var qty = $('#qty_input').val();
            this.redraw(sku);
        }
    },
    /**
     * 将对应的 SKU 信息同步到页面上。这里做出具体的操作
     */
    redraw: function(data) {
        var sku = $('#product_view').data('sku');
        data = $.extend(true, {}, data, sku);
        var qty = $('#qty_input').val();
        if(!data.price) {
            data.price = $('#product_price_tr').data('price');
        }
        $('#product_price').text( qty * data.price );
    }


};