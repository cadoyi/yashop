/**
 * 提交订单页面
 * 
 */
jQuery(function( $ ) {
    (function() {
        if($('#address_bar').length > 0 && $('.address-card').length > 0) {
            var address = $('.address-card').get(0);
            var label = $(address).find('.address-label');
            if(label.length) {
                label.trigger('click');
            }  
        }
    })();
    $('#submit_order').on('click', function( e ) {
        var addressBar = $('#address_bar');
        if(addressBar.length) {
            var input = $('input[name="address_id"]').filter(':checked');
            if(!input.length) {
                alert('请 输入/选择 送货地址');
                stopEvent(e);
                return;
            }
        }
        var methodInput = $('input[name="payment_method"]').filter(':checked');
        if(!methodInput.length) {
            alert('请选择付款方式');
            stopEvent(e);
            return;
        }
    });


});