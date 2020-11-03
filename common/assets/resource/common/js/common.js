var stopEvent = function(e , stopIm) {
    e.preventDefault();
    e.stopPropagation();
    if(stopIm) {
        e.stopImmediatePropagation();
    }
};

var op = {
    _options: function( options, closeOnClickOutside ) {
        if(typeof options === 'string') {
            options = { text: options };
        } else {
            options = options || {};
        }
        if(!(closeOnClickOutside in options)) {
            options.closeOnClickOutside = closeOnClickOutside;
        }
        return options;
    },
    success: function(options, closeOnClickOutside) {
        options = this._options(options, closeOnClickOutside);
        options.icon = 'success';
        return swal(options);
    },
    error: function( options, closeOnClickOutside ) {
        options = this._options(options, closeOnClickOutside);
        options.icon = 'error';
        return swal(options);
    },
    warning: function( options, closeOnClickOutside) {
        options = this._options(options, closeOnClickOutside);
        options.icon = 'warning';
        return swal(options);
    },
    info: function( options, closeOnClickOutside) {
        options = this._options(options, closeOnClickOutside);
        options.icon = 'info';
        return swal(options);
    },
    alert: function( options, closeOnClickOutside) {
        options = this._options(options, closeOnClickOutside);
        return swal(options);
    },
    /**
     * op.confirm('确定要删除这个选项吗? ').then(function( value ) {
     *     if(value) {
     *         console.log('您点击了确定按钮!');
     *     } else {
     *         console.log('您点击了取消按钮!');
     *     }
     * });
     * 
     * @param object  选项.
     * @return swal
     */
    confirm: function( options ) {
        options = this._options(options);
        options.className = 'swal-confirm';
        options.buttons = {
            cancel : {
                text: "取消",
                value : false,
                visible: true,
                closeModal : true,
            },
            confirm : {
                text: "确定",
                value : true,
                closeModal : true, 
            }
        };
        return swal(options);
    },
    msg: function( text ) {
        return swal({ 
            text: text, 
            button: false,
            className: 'swal-msg',
            timer: 2000,
        });
    }
};