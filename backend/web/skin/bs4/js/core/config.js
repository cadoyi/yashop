
jQuery(function( $ ) {

    $('#config_menu').find('.active').addClass('open');
    $('#config_menu').on('click', 'a', function( e ) {
        var self = $(this);
        if(self.attr('href') === '#') {
            e.preventDefault();
            e.stopPropagation();
            self.parent().toggleClass('open');
        }
    });


    $('#config_form').on('click', '.fieldset-title', function( e ) {
        e.preventDefault();
        e.stopPropagation();
        var fieldset = $(this).closest('.fieldset');
        fieldset.toggleClass('collapsed');
    });
});