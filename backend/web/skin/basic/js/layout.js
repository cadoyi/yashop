/**
 *
 *
 * 
 */
jQuery(function($) {

    // 展开/隐藏 左侧菜单栏, 并记住设置.
    ;(function() {
        if(!hasStorage('localStorage')) return;

        var storage = window['localStorage'];
        var closed = storage.getItem('toggle-closed');
        var opened =!closed;
        var toggle = function( open ) {
            if(open) {
                $('body').addClass('open-sidebar');
                storage.removeItem('toggle-closed');
            } else {
                $('body').removeClass('open-sidebar');
                storage.setItem('toggle-closed', 1);
            }
            opened = !storage.getItem('toggle-closed');
        }
        toggle(opened);

        $(document).on('click', '[toggle-sidebar]', function(e) {
            stopEvent(e);
            toggle(!opened);
        });
    })();



    // 左侧菜单栏调整
    $('aside.main-sidebar .menu > li.active > a[href="#"]').addClass('active');
    $('aside.main-sidebar .menu').on('click', 'li > a[href="#"]', function( e ) {
        stopEvent(e);
        $(this).parent().toggleClass('closed');
        $(this).toggleClass('active');
    });


});