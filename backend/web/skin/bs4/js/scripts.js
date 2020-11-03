
/**
 * grid-view 设置.
 */
jQuery(function( $ ) {

    $('.grid-view').on('change', '.swicher', function( e ) {
        var self = $(this);
        var value = self.val();
        var paramName = self.attr('page-size-param');
        var params = new URLSearchParams(location.search);
        params.set(paramName, value);
        location.search = '?' + params.toString();
    }).on('change', '.jumper > [type="number"]', function( e ) {
        var input = $(this);
        var value = input.val();
        var paramName = input.attr('page-param');
        var params = new URLSearchParams(location.search);
        params.set(paramName, value);
        location.search = '?' + params.toString();
    });



});