/**
 * 提交订单页面
 * 
 */
jQuery(function( $ ) {
    
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