/**
 * 使用 fileupload 插件来完成上传操作.
 *
 * 模板:
 * <div class="form-group gallery">
 *     <input type="file" name="gallery['images']" />
 * </div>
 *
 * 选项:
 *    container: form-group 选择器.
 *    url:       上传的 URL
 *    sortable:  是否需要排序
 *    values:    原始信息
 *
 * 
 */
$.cado || ($.cado = {});
$.cado.muploader = function( fileInput, options ) {
    if(typeof $.cado.muploader.index === 'undefined') {
        $.cado.muploader.index = 0;
    }
    fileInput = $(fileInput);
    var container = fileInput.parent();
    container.attr('cado-muploader', true);

    var stopEvent = function( e ) {
        e.preventDefault();
        e.stopPropagation();
    };
    if(!fileInput.attr('id')) {
        fileInput.attr('id', 'cadomuploader_' + $.cado.muploader.index++);
    }
    var fileInputId = fileInput.attr('id');
    var fileInputName = fileInput.attr('name');
    if(fileInputName && !options.paramName) {
          options.paramName = fileInputName;
    }
    var hiddenInputId = fileInputId + '_hidden';
    //var multiple = fileInput.attr('multiple');
    fileInput.attr('multiple', true);
    fileInput.removeAttr('name').hide();

    var helper = {
        previewLabelTemplate: '<div class="preview-label"><input id="{{id}}" type="hidden" name="{{name}}"><label for="{{labelfor}}">选择文件</label></div>',
        dropZoneTemplate: '<div class="drop-zone"><div class="previews"></div></div>',
        previewTemplate: '<div {{id}} class="preview"><img src="{{src}}" /><div class="progress"><div class="progress-bar" style="width: 15%;"></div></div></div>',
        html: function(template, data) {
            if(!data) {
                return template;
            }
            return template.replace(/\{\{(.+?)\}\}/g, function(match, capture) {
                if(typeof data[capture] !== 'undefined') {
                    return data[capture];
                }
                return match;
            });
        },
        generateId: function(prefix) {
            prefix = prefix || Date.now();
            return prefix + '_' + $.cado.muploader.index++;
        },
        generatePreview: function(id, src) {
            var self = this;
            var html = $(self.html(self.previewTemplate, { id: id, src: src}));
            dropZone.children('.previews').append(html);
        },
        preview: function( data ) {
            var self = this;
            $.each(data.files, function(i, file) {
                var reader = new FileReader();
                reader.onload = function( e ) {
                    var src = e.target.result;
                    var id = self.generateId();
                    self.generatePreview(id, src);
                    self.sendFile(id, file);
                }
                reader.readAsDataURL(file);
            });
        },
        removePreview: function( data ) {
            var preview = this.findPreview(data.file_id);
            if(preview.length) {
                preview.remove();
            }
        },
        findPreview: function( file_id ) {
            return dropZone.find('[' + file_id + ']');
        },
        updateProgress: function( data ) {
            var preview = this.findPreview(data.file_id);
            var value = parseInt((data.loaded / data.total) * 10000, 10) / 100;
            preview.find('.progress-bar').css({
                'width': value + '%'
            });
        },
        sendFile: function(id, file) {
            // 因为会 replace file input, 所以这里需要使用 id 来访问.
            var _options = {
                files: [file],
                file_id: id,             
            };
            if($.isFunction(options.formData)) {
                _options.formData = options.formData();
            }

            if($.type(options.formData) == 'object'){
                _options.formData = $.extend(true, {}, options.formData);
                _options.formData['file_id'] = id;
            } else {
                _options.formData = $.extend(true, [], options.formData);
                _options.formData.push({name: 'file_id', value: id });
            }

            $('#' + fileInputId).fileupload('add', _options);
        },
        done: function(res, status, jqXHR) {
            if(!res.file_id) {
                return;
            }
            var id = res.file_id;
            var preview = $('[' + id + ']');
            var removeLink = '<a class="remove" href="#"><i class="fa fa-remove"></i></a>';
            var buttons = '<div class="preview-buttons"><a class="move-left" href="#"><i class="fa fa-arrow-left"></i></a><a class="move-right" href="#"><i class=" fa fa-arrow-right"></i></a></div>';

            setTimeout(function() {
                preview.find('.progress').remove();
                preview.append(removeLink);
                preview.append(buttons);
            }, 1000);

            preview.data('res', res);
            //this.sort();
        },
        sort: function() {
            console.log('sort');
        },
    };
    var previewLink = $(helper.html(helper.previewLabelTemplate, {
        id: hiddenInputId,
        labelfor: fileInputId,
        name: fileInputName
    }));
    previewLink.insertAfter(fileInput);

    var dropZone = $(helper.html(helper.dropZoneTemplate));
    dropZone.insertAfter(previewLink);


    dropZone.on('click', '.remove', function( e ) {
        stopEvent(e);
        $(this).closest('.preview').remove();
        helper.sort();
    }).on('click', '.move-right', function( e) {
        stopEvent(e);
        var preview = $(this).closest('.preview');
        var next = preview.next();
            while(next.length) {
            if(next.data('res')) {
                break;
            }
            next = next.next();
        }
        if(next.length) {
            preview.insertAfter(next);
        }
        helper.sort();

    }).on('click', '.move-left', function( e) {
        stopEvent(e);
        var preview = $(this).closest('.preview');
        var prev = preview.prev();
        while(prev.length) {
            if(prev.data('res')) {
                break;
            }
            prev = prev.prev();
        }
        if(prev.length) {
            prev.insertAfter(preview);
        }
        helper.sort();
    }).on('click', function() {
        $('#' + fileInput.attr('id')).trigger('click');
    });

    options = $.extend({
        dropZone: dropZone,
        autoUpload: true,
        change: function(e, data) {
            helper.preview(data);
            return false;
        },
        drop: function(e, data) {
            helper.preview(data);
            return false;
        },
        progress: function(e, data) {
            helper.updateProgress(data);

        },
        add: function(e, data) {
            if (e.isDefaultPrevented()) {
                 return false;
            }
            data.process().done(function() {
                data.submit()
                    .done(helper.done)
                    .fail(function() {
                        helper.removePreview(data);
                    });
            });
        }

    }, options);
    
    fileInput.fileupload(options);

};
