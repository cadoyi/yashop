;(function( $ ) {
    /**
     * 停止事件传播,以及默认行为
     */
    var stopEvent = function( e ) {
        e.preventDefault();
        e.stopPropagation(); 
    };

    /**
     * 增加 URL 参数
     * _pm = 1: 单选
     * _pm = 2: 多选
     */
    var addUrlParam = function( link, value) {
        var anchor = $(link).get(0);
        if(/[?&]_pm=/.test(anchor.href)) {
            return;
        }
        var sep = (anchor.search.length > 0) ? '&' : '?';
        anchor.search += sep + '_pm=' + value;
        return;
    };

    var getInput = function( select, view ) {
        var Input = function( select, view ) {
            this._ = $(select);
            this.view = view;
            this.view.select = this;
        };
        Input.prototype = {
            init: function() {
                var options = this.findOptions();
                var self = this;
                options.each(function() {
                    var k = $(this).attr('value');
                    var v = $(this).text();
                    self.view.replaceOption(k, v);
                });
            }, 
            isMultiple: function() {
                return this._.attr('multiple');
            },
            findOption: function( value ) {
                return this._.find('option[value="' + value +'"]');
            },
            findOptions: function() {
                return this._.find('option[value]');
            }, 
            addOption: function(value, title) {
                var option = $('<option>', {
                    value: value,
                    selected: true,
                });
                option.text(title);
                this._.append(option);
                this.view.addOption(value, title);
            },
            cleanOptions: function() {
                this.findOptions().remove();
                this.view.cleanOptions();
            },
            removeOption: function(value, title) {
                this.findOption(value).remove();
                this.view.removeOption(value, title);
            },
            hasOption: function(value) {
                return this.findOption(value).length > 0;
            },
            hasOptions: function() {
                return this.findOptions().length > 0;
            },
            replaceOption: function(value, title) {
                if(this.hasOption(value)) {
                    var option = this.findOption(value);
                    option.attr('value', value);
                    option.text(title);
                    this.view.replaceOption(value, title);
                } else {
                    this.addOption(value, title);
                }
            },
            hasValue: function() {
                return this.hasOptions();
            }, 
            getValue: function() {
                var value = {};
                this.findOptions().each(function(_, option) {
                    var k = $(option).attr('value');
                    var v = $(option).text();
                    value[k] = v;
                });
                return value;
            },
            setValue: function(key, value) {
                var self = this;
                if($.isPlainObject(key)) {
                    values = key;
                } else {
                    values = {};
                    values[key] = value;
                }
                self.cleanOptions();
                $.each(values, function(k, v) {
                    self.addOption(k, v);
                });
            }
        };
        return new Input(select, view);
    };



    var PjaxModalInputView = function( container ) {
        this._ = container;
    };
    PjaxModalInputView.prototype = {
        findOption: function(value) {
            return this._.find('[data-pminput-value="' + value +'"]');
        },
        removeOption: function(value, title) {
           this.findOption(value).remove();
        },
        addOption: function(value, title) {
            var option = $('<a>', {
                class: 'pminput-value',
                href: '#',
                title: title,
                'data-pminput-value': value,
                'data-pminput-title': title,
            });
            option.text(title);
            option.append($('<i>', {
                'class': 'fa fa-close delete-value'
            }));
            this._.append(option);
        },
        cleanOptions: function() {
            this._.find('.pminput-value').remove();
        },
        replaceOption: function(value, title) {
            var option = this.findOption(value);
            if(option.length) {
                option.text(title);
                option.append($('<i>', {
                    'class': 'fa fa-close delete-value'
                }));                
            } else {
                this.addOption(value, title);
            }
        },
    };

    $.fn.pjaxModalInput = function() {
        var link = this;
        var container = link.closest('.pminput-container');
        var viewContainer = container.find('.pminput-values');
        var view = new PjaxModalInputView(viewContainer);
        var select = getInput(container.find('select'), view);

        select.init();

        addUrlParam(link, select.isMultiple() ? 2 : 1);

        container.on('click', '.delete-value', function( e ) {
            // 点击链接上的 close 按钮
            stopEvent(e);
            var parent = $(this).closest('.pminput-value');
            var value = parent.data('pminput-value');
            var title = parent.data('pminput-title');
            select.removeOption(value, title);
        }).on('click', '.pminput-value', function( e ) {
            // 点击链接本身不做任何操作.
            stopEvent(e);
        });

        link.openPjaxModal(function(pjax, opener) {
            var storage = $.pjaxModal.session(pjax);
            storage.set('pjaxmodal-input', select._);
            return select.getValue();
        }, function(value, oldValue, pjax, opener) {
            select.setValue(value);
        });

        return this;        
    };

    
    /**
     * 控制视图
     */
    var PjaxModalGridViewController = function( pjax, valueFunction ) {
        this.view = new PjaxModalGridView( pjax, this );
        this.grid = new PjaxModalGridTable( pjax, this, valueFunction);
        this.storage = new PjaxModalGridValue( pjax, this);
        this.container = this.getContainer();
    };
    PjaxModalGridViewController.prototype = {
        getContainer: function() {
            return this.view.container;
        },
        getSelect: function() {
            return this.view.getSelect();
        }, 
        addOption: function( value, title) {
            this.storage.addOption(value, title);
            this.view.addOption(value, title);
            this.grid.addOption(value, title);
        },
        removeOption: function(value, title) {
            this.storage.removeOption(value, title);
            this.view.removeOption(value, title);
            this.grid.removeOption(value, title);
        },
        replaceOption: function(value, title) {
            this.storage.replaceOption(value, title);
            this.view.replaceOption(value, title);
            this.grid.replaceOption(value, title);
        },
        cleanOptions: function(value, title) {
            this.storage.cleanOptions();
            this.view.cleanOptions();
            this.grid.cleanOptions();
        }
    };

    /**
     * gird view
     * 
     * @param {[type]} pjax [description]
     */
    var PjaxModalGridView = function( pjax, controller ) {
        this.controller = controller;
        this.container = $('<div>', { class: 'pminput-container' });
        pjax.prepend(this.container);
        this.select = $('<select>', { class: 'hidden'});
        this.container.append(this.select);
        this._ = $('<div>', { class: 'pminput-values'});
        this.container.append(this._);
        this.link = $('<a>', { 
            class: 'pminput-pjaxlink',
            href: '#'
        });
        this.link.text('确认选择');
        this.container.append(this.link);
        this.initSelectListener();
    };
    PjaxModalGridView.prototype = {
        initSelectListener: function() {
            var self = this;
            var origSelect = null;
            this.link.listenPjaxModal(function(value, pjax, listener) {
                var storage = $.pjaxModal.session(pjax);
                origSelect = storage.get('pjaxmodal-input');
                if(origSelect && origSelect.attr('multiple')) {
                    self.select.attr('multiple', true);
                }
                $.each(value, function(v, t) {
                    var option = $('<option>', {
                        value: v,
                        selected: true
                    });
                    option.text(t);
                    self.select.append(option);
                });
            }, function(value, pjax, listener) {
                var values = {};
                var options = self.select.find('option[value]');
                options.each(function() {
                    var k = $(this).attr('value');
                    var t = $(this).text();
                    values[k] = t;
                });
                return values;
            });
        },
        getSelect: function() {
            return this.select;
        },
        findOption: function(value) {
            return this._.find('[data-pminput-value="' + value +'"]');
        },
        removeOption: function(value, title) {
            this.findOption(value).remove();
        },
        addOption: function(value, title) {
            var option = $('<a>', {
                class: 'pminput-value',
                href: '#',
                title: title,
                'data-pminput-value': value,
                'data-pminput-title': title,
            });
            option.text(title);
            option.append($('<i>', {
                'class': 'fa fa-close delete-value'
            }));
            this._.append(option);
        },
        cleanOptions: function() {
            this._.find('.pminput-value').remove();
        },
        replaceOption: function(value, title) {
            var option = this.findOption(value);
            if(option.length) {
                option.text(title);
                option.append($('<i>', {
                    'class': 'fa fa-close delete-value'
                }));                
            } else {
                this.addOption(value, title);
            }
        },
    };

    var PjaxModalGridTable = function(pjax, controller, valueFunction) {
        this.pjax = pjax;
        this.controller = controller;
        var self = this;
        var checkradio = function( e ) {
            var input = $(this);
            var tr = input.closest('tr');
            var value = valueFunction.call(input, tr);
            if($.isPlainObject(value)) {
                var v = value.value;
                var t = value.title;
            } else {
                var v = tr.attr('data-key');
                var t = value;
            }
            if(input.is(':checked')) {
                self.controller.select.replaceOption(v, t);
            } else {
                self.controller.select.removeOption(v,t);
            }
            
        };
        this.pjax.on('change', 'tr[data-key] :checkbox', checkradio)
                 .on('change', 'tr[data-key] :radio', checkradio)
                 .on('change', 'input[type="checkbox"][name="selection_all"]', function(e ) {
                      var inputs = self.getInputs();
                      if(inputs) {
                          inputs.each(function(_, input) {
                              checkradio.call(input);
                          });
                      }
                 });
    };
    PjaxModalGridTable.prototype =  {
        getInput: function( value ) {
            var tr = this.pjax.find('tr[data-key="' + value + '"]');
            if(tr.length) {
                var td = tr.children('td').get(0);
                return $(td).children('input');                
            }
            return null;
        },
        getInputs: function( value ) {
            var trs = this.pjax.find('tr[data-key]');
            if(trs.length) {
                var inputs = [];
                trs.each(function() {
                    var td = $(this).children('td').get(0);
                    var input = $(td).children('input');
                    inputs.push(input);
                });
                return $(inputs);
            }
            return null;
        },
        check: function(value) {
            var input = this.getInput(value);
            if(input) {
                input.prop('checked', true);
            }
        },
        uncheck: function(value) {
            var input = this.getInput(value);
            if(input) {
                input.prop('checked', false);
            }
        },
        addOption: function(value, title) {
            this.check(value);
        },
        removeOption: function(value, title) {
            this.uncheck(value);
        },
        replaceOption: function(value, title) {
            this.check(value);
        },
        cleanOptions: function() {
            var inputs = this.getInputs();
            if(inputs) {
                inputs.prop('checked', false);
            }
        }
    };

    var PjaxModalGridValue = function(pjax, controller) {
        this.pjax = pjax;
        this.key = 'opener.value';
        this.controller = controller;
    };
    PjaxModalGridValue.prototype = {
        getValue: function() {
            var value = $.pjaxModal.
                _session(this.pjax).
                get(this.key);
            if(!$.isPlainObject(value)) {
                value = {};
                this.setValue(value);
            }
            return value;
        },
        setValue: function(value) {
            return $.pjaxModal.
               _session(this.pjax).
               set(this.key, value);
        },
        addOption: function(value, title) {
            var oldValue = this.getValue();
            oldValue[value] = title;
        },
        removeOption: function(value, title) {
            var oldValue = this.getValue();
            if(value in oldValue) {
                delete oldValue[value];
            }
        },
        replaceOption: function(value, title) {
            var oldValue = this.getValue();
            oldValue[value] = title;
        },
        cleanOptions: function() {
            this.setValue({});
        }
    };

    /**
     * grid view 的另一个包装器
     * this: grid-view
     *
     *  options:
     *      valueFunction: 获取一行值的 hash
     * 
     */
    $.fn.pjaxModalGrid = function( valueFunction ) {
        if(valueFunction === null || valueFunction === undefined) {
            valueFunction = 2;
        }
        if(!$.isFunction(valueFunction)) {
            var n = valueFunction;
            valueFunction = function(tr) {
                var td = tr.children('td').get(n);
                return $(td).text();
            };
        }
        var gridView  = $(this),
        table     = gridView.find('table'),
        pjax      = gridView.closest('.pjaxmodal-container');

        var view = new PjaxModalGridViewController( pjax, valueFunction);
        select    = getInput(view.getSelect(), view);
        select.init();
    
        var container = view.container;
        container.on('click', '.delete-value', function( e ) {
            // 点击链接上的 close 按钮
            stopEvent(e);
            var parent = $(this).closest('.pminput-value');
            var value = parent.data('pminput-value');
            var title = parent.data('pminput-title');
            select.removeOption(value, title);
        }).on('click', '.pminput-value', function( e ) {
            // 点击链接本身不做任何操作.
            stopEvent(e);
        });    
    }

})( jQuery );
