/**
 * 配置选项 js
 *
 * 
 */
jQuery(function( $ ) {

    $('#edit_config').find('input[type="password"]').each(function() {
        var view = $('<a show-secret href="#"><i class="fa fa-eye"></i> 查看</a>');
        var input = $(this);
        view.insertBefore(input);
        view.on('click', function() {
            if(input.attr('type') === 'password') {
                input.attr('type', 'text');
                view.html('<i class="fa fa-eye-slash"></i> 隐藏');
            } else {
                input.attr('type', 'password');
                view.html('<i class="fa fa-eye"></i> 查看');
            }
        });        
    });


});
