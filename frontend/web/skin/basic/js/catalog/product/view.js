/**
 * product view js file
 * 
 */
var swiper = new Swiper('.swiper-container', {
    loop: true,
    autoplay: true,
});



function ProductOption(productData, options, skus) {
    this.productData = productData;
    this.origOptions = options;
    this.options = null;
    this.skus = skus;
    this.length = productData.optionsLength;
    this.origPrice = productData.price;
    this.initOptions();
    this.buildOptions();
    this.bindEvents();
};
ProductOption.prototype = {
    initOptions: function() {
        if(this.options === null) {
            var data = {};
            var options = this.origOptions;
            $.each(options, function(i, option) {
                var name = option.name;
                data[name] = {};
            });
            var skus = this.skus;
            $.each(skus, function(i, sku) {
                $.each(sku, function(n,v) {
                    if(!(n in data)) {
                        return;
                    }
                    if(!data[n][v]) {
                       data[n][v] = {length: 0};
                    } 
                    data[n][v][sku.sku] = sku;
                    data[n][v]['length'] +=1;
                });
            });
            this.options = data;
        }
    },
    buildOptions: function() {
        var origOptions = this.origOptions;
        var options = this.options;
        $.each(origOptions, function(i) {
            var name = this.name;
            var option = options[name];
            var tr = $('<tr>', { class: 'product-options'});
            var td1 = $('<td>');
            var td2 = $('<td>');
            td1.text(name);
            tr.append(td1);     
            tr.append(td2);
            tr.insertBefore('tr.product-qty');
            $.each(option, function(v, vos) {
                var label = $('<label>', {
                    class: 'product-option-label'
                });
                var text = $('<span>');
                text.text(v);
                td2.append(label);
                var input = $('<input>', {
                    'product-option': i,
                    'type': 'radio',
                    'name': name,
                    'value': v,
                });
                label.append(input);
                label.append(text);
            });
        });
        this.bindOptionEvents();
        this.bindQtyEvents();
    },
    bindOptionEvents: function() {  // 绑定选项选择事件
        var self = this;
        $('.product-option-label input[type="radio"]').on('change', function( e ) {
            self.collectTotals();
        });
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
    collectTotals: function() {
        var sku = this.getSku(false);
        var qty = this.getQtyValue();
        if(sku === false) {
            var price = this.origPrice;
        } else {
            var skuModel = false;
            $.each(this.skus, function() {
                if(this.sku === sku) {
                    skuModel = this;
                    return false;
                }
            });
            var price = skuModel.finalPrice;
        }
        price = price * qty;
        $('#product_price').text(price);
    },
    bindEvents: function() {
        var self = this;
        $('[tocart_button]').on('click', function( e ) {
            stopEvent(e);
            var form = self.prepareForm('.addcart-form');
            if(form === false) {
                return;
            }
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
    getQtyValue: function() {
       return $('#qty_input').val();
    },
    getSku: function( showMessage ) {
        var options = this.options;
        var sku = [];
        var result = true;
        $.each(options, function(name, option) {
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
            return sku.join('-');
        }
        return result;
    },
    prepareForm: function(form) {
        var sku = this.getSku(true);
        if(sku === false) {
            return false;
        }
        var qty = this.getQtyValue();
        var skuModel = false;
        $.each(this.skus, function() {
            if(this.sku === sku) {
                skuModel = this;
                return false;
            }
        });
        if(skuModel === false) {
            return false;
        }
        $(form).find('[name="product_sku"]').val(sku);
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
