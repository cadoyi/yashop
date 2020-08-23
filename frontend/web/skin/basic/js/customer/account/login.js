/**
 *
 *
 *
 */
jQuery(function( $ ) {
    if(document.getElementById('customer_register_form')) {
        var form = $('#customer_register_form');
        $('#send_code').on('click', function( e ) {
            stopEvent(e);
            var id = 'register-username',
                attribute = form.yiiActiveForm('find', id),
                input = $('#' + id),
                messages = [],
                defer = $.Deferred();
            attribute.validate(attribute, input.val(), messages, defer, form);
            if(messages.length) {
                var error = {};
                error[id] = messages;
                form.yiiActiveForm('updateMessages', error);
                return;
            }
            var url = '/customer/account/send-register-code.html?username=';
            url += encodeURIComponent(input.val());
            $.get(url).then(function( res ) { console.log(res);
                if(!res.success) {
                    alert(res.message);
                    return;
                }
                $('#send_code').text('发送成功');
            });
        });
            

    }
});