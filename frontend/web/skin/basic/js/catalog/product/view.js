/**
 * product view js file
 * 
 */
var swiper = new Swiper('.swiper-container', {
    loop: true,
    autoplay: true,
});

function ProductOption( product, options, skus ){
    this.options = options;
    this.skus = skus;
    this.origPrice = product.price;
    this.productId = product.id;
    this.productSku = product.sku;
    this.initOptions();
    this.bindQtyEvents();
    this.bindCartEvents();
};
ProductOption.prototype = {
    initOptions: function() {
        var self = this;
        $.each(this.skus, function(i, sku) {
            var skusplit = this.sku.split('-');
            skusplit.shift();
            $.each(skusplit, function(j, value) {
                var option = self.options[j];
                var values = option.values;
                if($.inArray(value, values) < 0) {
                    option.values.push(value);
                }
            });
        });
        this.buildOptions();
    },
    buildOptions: function() { // 生成选项.
        var self = this;
        $.each(this.options, function(i, option) {
            var name = option.name;
            var tr = $('<tr>', { class: 'product-options'});
            var td1 = $('<td>');
            var td2 = $('<td>');
            td1.text(name);
            tr.append(td1);     
            tr.append(td2);
            tr.insertBefore('tr.product-qty');
            $.each(option.values, function(j, value) {
                var label = $('<label>', {
                    class: 'product-option-label'
                });
                var text = $('<span>');
                text.text(value);
                td2.append(label);
                var input = $('<input>', {
                    'product-option': i,
                    'type': 'radio',
                    'name': name,
                    'value': value,
                });
                label.append(input);
                label.append(text);
                input.on('change', function( e ) {
                    self.changeInput(this, e);
                });
                $.each(self.skus, function(n, sku) {
                    var attrs = sku.attrs;
                    var relation = false;
                    $.each(attrs, function(_name, _value) {
                        if(_name == name && _value == value) {
                            relation = true;
                            return false;
                        }
                    });
                    if(relation) {
                        var _skus = label.data('skus') || [];
                        _skus.push(sku);
                        label.data('skus', _skus);
                    }
                });
            });
        });
    },
    changeInput: function( input, e ) {
        var self = this;
        self.collectTotals();
    },
    bindQtyEvents: function() {
        var self = this;
        $('[add-qty]').on('click', function(e) {
            var input = $(this).closest('.qty-value').find('input');
            var v = +input.val() + 1;
            var max = input.attr('max') || ( v + 1);
            if(v > max) {
                v = +max;
            }
            input.val(v);
            input.trigger('change');            
        });
        $('[sub-qty]').on('click', function( e ) {
            stopEvent(e);
            var input = $(this).closest('.qty-value').find('input');
            var v = +input.val() - 1;
            if(v < 1) {
                v = 1;
            }
            input.val(v);
            input.trigger('change');            
        });
        $('#qty_input').on('change', function(e) {
            self.collectTotals();
        }); 
    },
    collectTotals: function() {  // 计算价格
        if(this.skus.length) {
            var sku = this.getSku(false);
            if(sku !== false) {
                var price = sku.finalPrice;
            } else {
                var price = this.origPrice;
            }            
        } else {
            var price = this.origPrice;
        }
        var qty = +this.getQtyInput().val();
        price = price * qty;
        $('#product_price').text(price);
    },
    getQtyInput: function() {
       return $('#qty_input');
    },
    getSku: function( showMessage ) {
        var options = this.options;
        var sku = [];
        var result = true;
        $.each(options, function(ii, option) {
            var name = option.name;
            var checked = $('input[name="'+name+'"]').filter(':checked');
            if(!checked.length) {
                if(showMessage) {
                     alert('请选择"' + name + '"');
                }
                result = false;
                return false;
            }
            sku.push(checked.val());
        });
        if(result) {
            var skusku = this.productSku + '-' + sku.join('-');
            var skuModel = false;
            $.each(this.skus, function(_, sku) {
                if(skusku === sku.sku) {
                    skuModel = sku;
                    return false; 
                }
            });
            return skuModel;
        }
        return result;
    },
    bindCartEvents: function() {
        var self = this;
        $('[tocart_button]').on('click', function( e ) {
            stopEvent(e);
            var form = self.prepareForm('.addcart-form');
            if(form === false) {
                return;
            }
            console.log(form);
            form.submit();
        });
        $('[checkout_button]').on('click', function( e ) {
            stopEvent(e);
            var form = self.prepareForm('.checkout-form');
            if(form === false) {
                return form;
            }
            form.submit();
        });
    },
    prepareForm: function(form) {
        if(this.skus.length) {
            var sku = this.getSku(true);
            if(sku === false) {
                return false;
            }
            $(form).find('[name="product_sku"]').val(sku.id);            
        } else {
            $(form).find('[name="product_sku"]').remove();
        }
        console.log($(form));
        var qty = this.getQtyInput().val();
        $(form).find('[name="qty"]').val(qty);
        return $(form);
    }
};


jQuery(function( $ ) {
    $('#addto_wishlist').on('click', function( e ) {
        stopEvent(e);
        var self = $(this);
        var url = add_wishlist_url;
        var product_id = self.attr('product-id');
        var cancel = $(this).hasClass('active');
        $.post(url, {
            product_id: product_id,
            cancel: cancel ? 1 : 0
        }).then(function( res ) {
           if(res.success) {
               if(res.canceled) {
                   self.removeClass('active');
               } else {
                   self.addClass('active');
               }
           } else {
              alert(res.message);
           }
        }, function() {
            alert('网络错误,请重试! ');
        });
    });
});
