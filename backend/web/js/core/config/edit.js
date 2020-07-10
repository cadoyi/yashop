/**
 *
 * 
 */
jQuery(function( $ ) {
    $('.config-container').on('click', '[toggle-fieldset]', function( e ) {
        stopEvent(e);
        var container = $(this).closest('.config-fieldset');
        container.toggleClass('open');
    });
});