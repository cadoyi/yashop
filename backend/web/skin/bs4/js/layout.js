/**
 *
 * 
 */
jQuery(function( $ ) {
    $('#layout_sidebar li.active').find('a.has-child').addClass('open');

    $('#layout_sidebar').on('click', 'a.has-child', function( e ) {
         e.preventDefault();
         e.stopPropagation();
         $(this).toggleClass('open');
    });

});