
jQuery(function( $ ) {

    $('#issue_menu').on('click', 'a[href="#"]', function( e ) {
        stopEvent(e);
        $(this).toggleClass('open');
    }).find('li.active > a[href="#"]').addClass('open');


    $('#issue_search_form').on('submit', function( e ) {
        var form = $(this);
        var input = form.find('input[name="q"]');
        var text = (input.val() || '').trim();
        if(!text.length) {
            stopEvent(e);
            return;
        }
        $(this).submit();
    });

});