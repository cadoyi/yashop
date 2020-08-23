/**
 * product view js file
 * 
 */
var swiper = new Swiper('.swiper-container', {
    loop: true,
    autoplay: true,
});
var clickable = {
    '[add-qty]': function( e ) {
        stopEvent(e);
        var input = $(this).closest('.qty-value').find('input');
        var v = +input.val() + 1;
        var max = input.attr('max') || ( v + 1);
        if(v > max) {
            v = +max;
        }
        input.val(v);
        input.trigger('change');
    },
    '[sub-qty]': function( e ) {
        stopEvent(e);
        var input = $(this).closest('.qty-value').find('input');
        var v = +input.val() - 1;
        if(v < 1) {
            v = 1;
        }
        input.val(v);
        input.trigger('change');
    },
    '[checkout_button]': function( e ) {
       // stopEvent(e);
    },
    '[tocart_button]': function( e ) {
       // stopEvent(e);

    }
};
function ProductOption(productData, options, skus) {
    this.length = productData.optionsLength;
    this.origPrice = productData.price;
};
ProductOption.prototype = {
    changePrice: function() {

    }
};
jQuery(function( $ ) {
    $.each(clickable, function(k, v) {
        $(document).on('click', k, v);
    });
});
