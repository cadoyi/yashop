/**
 *
 *
 * 
 */
jQuery(function($) {

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

    
    $('aside.main-sidebar .menu').on('click', 'li > a[href="#"]', function( e ) {
        stopEvent(e);
        $(this).toggleClass('active');
    });


});