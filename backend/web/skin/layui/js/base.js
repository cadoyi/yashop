/**
 * base js
 */
var helper = {};

/**
 * button 按钮
 */
helper.Button = function( button ) {
    this.element = button;
    this.$ = $(button);
};
helper.Button.prototype = {
    lock: function(text) {
        this.$
        .attr('disabled', 'disabled')
        .addClass('layui-disabled');
        if(text) {
            this.$.text(text);
        }
        return this.$;
    },
    unlock: function( text ) {
        this.$
          .removeAttr('disabled')
          .removeClass('layui-disabled');
        if(text) {
            this.$.text(text);
        }
        return this.$;
    }
};

