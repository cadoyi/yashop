/**
 * 购物车页面的 js 逻辑
 *
 *
 * @depends
 *    qtyLink  -- 更新 qty 数量的链接.
 */
jQuery(function( $ ) {

    $('#cart_items').on('change', '.qty-input', function( e ) {
        var input = $(this);
        var value = input.val();
        if(isNaN(value) || !value ) {
            e.preventDefault();
            return;
        }
        var id = $(this).attr('item-id');
        var link = qtyLink + '?id=' + id;
        $.post(link, {
            qty: $(this).val(),
        }).then(function( res ) {
            if(res.success) {
                var data = res.data;
                var price = data.price;
                var qty = data.qty;
                input.val(qty);
                var priceDiv = input.closest('tr').find('.price');
                priceDiv.text('￥' + price);
                $('.select-on-check-all').trigger('change');
            } else {
                alert(res.message);
                location.reload();
            }
        }, function( e ) {
            alert('Network error');
        });
    });


    /**
     * 选择购物车项目的时候
     */
    $('.select-on-check-all').on('change', function( e ) {
        var checkboxes = $('.checkout-it').filter(':checked');
        if(checkboxes.length >0) {
            var prices = 0;
            checkboxes.each(function() {
               var tr = $(this).closest('tr');
               var price = tr.find('.price').text().replace(/[^0-9.]/, '');
               price = +price;
               prices += price;
            });
            $('#checkout_show_total').text(prices);
            $('[checkout-button]').prop('disabled', false);
        } else {
            $('[checkout-button]').prop('disabled', true);
            $('#checkout_show_total').text('0.00');
        }
    });



});