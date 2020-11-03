/**
 *
 * 
 */
jQuery(function( $ ){
    var initConfirmHandler = function() {
        var handler = function (event) {
            var $this = $(this),
                method = $this.data('method'),
                message = $this.data('confirm'),
                form = $this.data('form');

            if (method === undefined && message === undefined && form === undefined) {
                return true;
            }
           
            if(message !== undefined) {
                op.confirm( message ).then(function(value) {
                    if(value) {
                        yii.handleAction($this, event);
                    } else {
                        return;
                    }
                });
                event.stopImmediatePropagation();
                return false;                
            } else {
                return;        //让下一个处理去处理.
            }
        };
        // handle data-confirm and data-method for clickable and changeable elements
        $('body').on('click.appConfirm', yii.clickableSelector, handler)
            .on('change.appConfirm', yii.changeableSelector, handler);
    }
    initConfirmHandler();
});

jQuery(function( $ ) {
    $('#layout_sidebar li.active').find('a.has-child').addClass('open');

    $('#layout_sidebar').on('click', 'a.has-child', function( e ) {
         e.preventDefault();
         e.stopPropagation();
         $(this).toggleClass('open');
    });




});