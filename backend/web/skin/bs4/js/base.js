
var op = {
    success: function(options) {
        options = options || {};
        options.icon = 'success';
        return swal(options);
    },
    error: function( options ) {
        options = options || {};
        options.icon = 'error';
        return swal(options);
    }
};