/**
 *
 *
 * @required jquery.js
 * @required bootstrap.js
 * @required jquery.pjax.js
 *
 * <?php PjaxModal::widget(['id' => 'mypjax' ]) ?>
 *
 * <script>
 *    //需要使用 data-pjaxmodal="#mypjax"
 *    var opener = $.pjaxModal.open('a.somelink');  
 *
 *    // 发送旧的值
 *    opener.send(value);
 *
 *    // 或者使用回调发送旧的值
 *    opener.send(function() {
 *        return $('#xxx').val();
 *    });
 *
 *    // 接收并应用值
 *    .apply(function(value, oldValue) {
 *        if(value === oldValue) return;
 *        $('#xxx').val(value);
 *    });
 *    
 * </script>
 *
 *
 * 
 * 对于modal 子页面
 * <script>
 *    var listener = $.pjaxModal.listen('pjax 或者 pjax 子元素选择器');
 *    listener.read(function(value) {
 *        //读取旧的值, 并应用
 *    });
 *    // 或者直接读取值
 *    var value = listener.readValue();
 *
 *    // 当选择值之后, 可以使用 writeValue 发送值
 *    listener.writeValue(value)
 *
 *    // 或者使用回调
 *    listener.write(function(oldValue) {
 *        var value = [];
 *        $(':checked').each(function() {
 *             value.push($(this).val());
 *        });
 *        return value;
 *    });
 * 
 * </script>
 * 
 * 
 *
 *
 *
 * 
 */

;(function( $ ){

   var dataAttribute = 'data-pjaxmodal';
   var stopEvent = function( e, saveP) {
       e.preventDefault();
       if(!saveP) {
          e.stopPropagation();
       }
   };

   var jq = function(id) {
      if(typeof id === 'string' && id.indexOf('#') !== 0) {
          id = '#' + id;
      }
      return $(id);
   };

   var pjaxEvents = {

       /**
        * 点击链接之后, pjax 请求之前触发, 用于改变请求选项.
        * 
        *  签名: function(event, options, globalOptions, pjax)
        *      options: 当前的请求选项
        *      globalOptions: 修改里面的值会影响后续的 pjax 的所有请求
        *      pjax: pjax 元素.
        */
       beforeRequest: 'beforeRequest',


       /**
        * pjax 请求之后的事件,可以用于附加事件处理器.
        *
        * 签名: function(event, xhr, options, globalOptions, pjax)
        *    xhr: jqXHR
        *    options: ajax 请求选项
        *    globalOptions: 全局请求选项
        *    pjax: pjax 元素
        *
        *  
        */
       afterRequest: 'afterRequest'
   }

    
   var hiddenEvent = function( e ) {
       var n = $(this).is(':visible') ? 1 : 0;
       if($('.modal:visible').length > n) {
           $('body').addClass('modal-open');
       }
   };

   $('.modal').off('hidden.bs.modal', hiddenEvent)
              .on('hidden.bs.modal', hiddenEvent);

   var ModalSizer = function( modal ) {
       this.modal = modal;
       this.dialog = modal.find('.modal-dialog');
       this.init();
   };
   ModalSizer.prototype = {
       init: function() {
          var d = this.dialog;
           if(d.attr('initsize')) return;
           if(d.hasClass('modal-lg')) return d.attr('initsize', 'modal-lg');
           if(d.hasClass('modal-sm')) return d.attr('initsize', 'modal-sm');
       },
       remove: function() {
           return this.dialog.removeAttr('style').removeClass('modal-lg').removeClass('modal-sm');
       },
       resize: function(size) {
           this.remove();
           switch(size) {
              case 'modal-lg':
              case 'lg':
              case 'large':
                  this.dialog.addClass('modal-lg');
                  break;
              case 'modal-sm':
              case 'sm':
              case 'small':
                  this.dialog.addClass('modal-sm');
                  break;
              default:
                  if(typeof size === 'string') {
                      size = !isNaN(size) ? (size + 'px') : size;
                      this.dialog.css({ 'width': size });
                  }
           }
       },
       restore: function() {
           var initSize = this.dialog.attr('initsize') || '';
           this.remove().addClass(initSize);
       }
   };

   /**
    * 使用一个链接来触发 pjaxmodal
    *  链接有 <a data-pjaxmodal="#pjaxmodal">...</a>
    *  自动开启 pjaxmodal 功能
    * 
    * @param  object options  配置选项
    *     modal:   模态框的 ID
    *     id:      pjax container 的 ID
    *     content: 模态框初始显示内容,比如一个 loading 图片
    *   以及 pjax 的原始选项,比如
    *     push: false
    *     history: false
    *     ...
    *     
    */
   $.pjaxModal = function( options ) {
      var origOptions = options,
          defaultOptions = $.pjaxModal.defaultOptions,
          options = $.extend(true, {}, defaultOptions, origOptions),
          modal = jq(options.modal),
          pjax = jq(options.id),
          linkSelector = 'a['+ dataAttribute +'="#' + options.id +'"]';

      var sizer = new ModalSizer(modal);

      // 模态框显示以前触发
      modal.on('show.bs.modal', function( e ) {
          $.pjaxModal.openSession( modal );
          pjax.html(options.content);
      }).on('hidden.bs.modal', function( e ) { //完全关闭后触发
          $.pjaxModal.closeSession( modal );
          pjax.html(options.content);    // 恢复原始内容.
          sizer.restore();
          
      }).on('pjax:error', function(event, xhr, status) {
          event.preventDefault();   //阻止使用默认行为打开链接.
          console.log('pjax:error');
          alert(status);
      });

      $(document)
      .off('click.pjaxmodal', linkSelector)
      .on('click.pjaxmodal', linkSelector, function( e ) {
          stopEvent(e);
          var link  = this, 
              $link = $(this),
              id    = $.pjaxModal.generateId(link);

          var o = $.extend(true, {
             url: $link.attr('href'),
          }, options);

          // 可以附加用于修改请求参数
          $link.trigger(pjaxEvents.beforeRequest, [ o, options, pjax ]);

          // 显示 modal 以及创建 session 数据.
          var size = $link.data('pjaxmodal-size');
          sizer.resize(size);
          modal.modal('show');

          $.pjaxModal._session(modal).add({
              'open.id': id,
              'open.link': link,
          });

          var xhr = $.pjax(o);

          $link.trigger(pjaxEvents.afterRequest, [ xhr, o, options, pjax ]);
      });
   }

   // 默认的 pajx 选项.
   $.pjaxModal.defaultOptions = {
       push:    false,
       history: false
   };

   // 为链接或者元素生成唯一 ID 值.
   $.pjaxModal.number = 0;  
   
   /**
    * 生成 id 值或者返回旧的 ID 值.
    */
   $.pjaxModal.generateId = function( ele ) {
      $(ele).each(function() {
          var self = $(this);
          var id = self.attr('id');
          if(id === undefined || id === null) {
              id = 'pjaxmodal_generate_' + $.pjaxModal.number++;
              self.attr('id', id);
          }
      });
      return $(ele).attr('id');
   }

   /**
    * 存储相关的数据.
    */
   var ModalStorage = function( data ) {
       data = data || {};
       var Storage = function( data ) {
           this.storage = data;
       }
       Storage.prototype = {
           set: function(key, value) {
               if($.isPlainObject(key)) {
                   this.clean();
                   this.merge(key);
               } else {
                   this.storage[key] = value;
               }
           },
           add: function(key, value) {
               if($.isPlainObject(key)) {
                   this.merge(key);
               } else {
                   this.storage[key] = value;
               }
           },
           get: function(key) {
               if(this.has(key)) {
                   return this.storage[key];
               }
               return null;
           },
           getSet: function(key, value) {
               if(this.has(key)) {
                   return this.get(key);
               }
               if($.isFunction(value)) {
                   value = value.call(this);
               }
               this.storage[key] = value;
               return value;
           },
           has: function(key) {
              return key in this.storage;
           },
           clean: function() {
               for(var k in this.storage) {
                   delete this.storage[k];
               }
           },
           merge: function(data) {
               for(var k in data) {
                   this.storage[k] = data[k];
               }
           }
       };
       return new Storage(data);
   }

   $.pjaxModal.openSession = function( modal ) {
       $(modal).closest('.modal').data('pjaxmodal', { data: {}, _data: {}});
   };

   $.pjaxModal.closeSession = function( modal ) {
      $(modal).closest('.modal').removeData('pjaxmodal');
   };

   $.pjaxModal.ensureLocal = function( modal ) {
       modal = $(modal).closest('.modal');
       var storage = modal.data('_pjaxmodal');
       if(!storage) {
           storage = { data: {}, _data: {}};
           modal.data('_pjaxmodal', storage);
       }
       return storage;
   }

   /**
    * 获取 modal 上的 session 数据.
    *   当 modal show 的时候会建立这个数据.
    *   当 modal hide 的时候会销毁这个数据.
    * 不应该存储这个数据对象, 因为他可能已经被销毁.
    */
   $.pjaxModal.session = function( modal ) {
       modal = $(modal).closest('.modal');
       var data = modal.data('pjaxmodal');
       var storage = data && data.data ? data.data : null;
       return ModalStorage(storage);
   }

   /**
    * 内部使用的生命周期数据.
    */
   $.pjaxModal._session = function( modal ) {
       modal = $(modal).closest('.modal');
       var data = modal.data('pjaxmodal');
       var storage = data && data._data ? data._data : null;
       return ModalStorage(storage);
   }

   /**
    * 在 modal 生命周期内都有效的数据.
    * 这个数据在页面内永久有效.
    */
   $.pjaxModal.local = function( modal ) {
       var data = $.pjaxModal.ensureLocal( modal );
       return ModalStorage( data.data );
   }

   /**
    * 本地隐藏的数据.
    */
   $.pjaxModal._local = function( modal ) {
       var data = $.pjaxModal.ensureLocal( modal );
       return ModalStorage( data._data );
   }


   // pjax 子页面需要调用它.当点击 link 的时候会发送新的值.
   // 只针对一个元素, 如果多个元素, 则需要使用 $.fn.listenPjaxModal
   // 
   $.pjaxModal.listen = function( link ) {
       link = $(link);
       if(link.data('pjaxmodal.listener')) return link.data('pjaxmodal.listener');
       
       var pjax = link.closest('.pjaxmodal-container');
       if(!pjax.length) throw 'Cannot find pjax container';

       var modal     = pjax.closest('.modal'),
          writer     = $.Callbacks('unique'),
          fireWriter = function(then) {
              if(!writer.fired()) {
                  if(!writer.has()) {
                      writer.add(function() { modal.modal('hide'); });
                  }
                  if($.isFunction(then)) { writer.add(then); }
                  writer.fire(link, pjax);
               }
          },
          getCallback = function(name) {
               var id  = $.pjaxModal._session(pjax).get('open.id'),
                   key = id + '.' + name,
                   storage = $.pjaxModal._local(pjax);
               return storage.getSet(key, function() { return $.Callbacks('unique'); });
          },
          readOpenerValue = function() {
               var storage = $.pjaxModal._session(pjax);
               if(storage.has('opener.value')) {
                   return storage.get('opener.value');
               }
               var sender = getCallback('sender');
               sender.fire(pjax);
               return storage.getSet('opener.value', null);
          };
       link.on('click.pjaxmodal', function( e ) {
           stopEvent(e);
           fireWriter();
       });
       var Listener = function() {};
       Listener.prototype = {
          readValue: function() {
              return readOpenerValue();
          },
          /**
           * 读取值并执行回调函数, 可以多次读取.
           * 回调函数签名: function(value, pjax)
           * this: link
           */
          read: function( func ) { // read 立即执行
              var value = this.readValue();
              func.call(link, value, pjax, this);
              return this;
          },
          /**
           * 写入值, 只能写入一次.
           */
          writeValue: function( value ) {
              return this.write(function() {
                  return function() { return value; };
              });
          },
          /**
           * 写入值的回调,可以多次设置,但是最后一次生效.
           * 签名: function( value, pjax )
           *     value: 读取到的值
           *
           * 如果返回 undefined, 则表示直接关闭,并不发送值.
           * 返回其他值都会发送
           * this: link
           * 
           */
          write: function( func ) {
              if(writer.fired()) {
                  console.warn('already fired');
                  return this;
              }
              var self     = this;
              var value    = self.readValue();

              writer.empty().add(function(link, pjax) {
                  var newValue = func.call(link, value, pjax, self);
                  if(typeof newValue !== 'undefined') {
                      var receiver = getCallback('receiver');
                      if(!receiver.fired()) {
                          receiver.add(function() { modal.modal('hide'); });   
                      }  
                      receiver.fire(newValue, value);                     
                  } else {
                      modal.modal('hide'); 
                  }
              });
              return this;
          },
          /**
           * 关闭,但是不发送值
           */
          close: function(then) {
              fireWriter(then);
          },
          /**
           * 写入数据并立即关闭.
           * 
           * @param  function func 写入
           */
          writeClose: function( func ) {
              if(typeof func === 'function') {
                   return this.write(func).close();
              }
              return this.close();
          }
       }
       var listener =  new Listener();
       link.data('pjaxmodal.listener', listener);
       return listener;
   };


  // 首先被调用.
  // 只针对一个元素, 如果多个元素, 使用 $.fn.openPjaxModal
  $.pjaxModal.open = function( link ) {
       var link = $(link),
           id   = $.pjaxModal.generateId(link);

       if(link.data('pjaxmodal.opener')) return link.data('pjaxmodal.opener');
       
       var pjaxSelector = link.attr(dataAttribute),
           pjax         = $(pjaxSelector),
           dataFunction = function( data ) { return function() { return data; }; },
           getCallback  = function(name) {
               var storage = $.pjaxModal._local(pjax),
                   key     = id + '.' + name;
                   return storage.getSet(key, function() { return $.Callbacks('unique'); });
           },
           Opener       = function() {};

           Opener.prototype = {
               /**
                * 发送数据的回调
                * 签名: function( pjax, opener ) {}
                * this: link 打开 pjaxmodal 窗口的元素.
                */
               send: function( data ) {
                  var self = this;
                  var func = $.isFunction(data) ? data : dataFunction(data);
                  getCallback('sender').add(function(pjax) {
                      var value = func.call(link, pjax, self);
                      if(value !== undefined) {
                         $.pjaxModal._session(pjax).set('opener.value', value);              
                      }
                  });
                  return this;
               },
               /**
                * 接收数据的回调
                * 签名: function( value, oldValue, pjax, container )
                * this: link
                */
               receive: function( func ) {
                   var self = this;
                   getCallback('receiver').add(function( value, oldValue ) {
                       return func.call(link, value, oldValue, pjax, self);
                   });
                   return this;
               }
           };
       var opener = new Opener();
       link.data('pjaxmodal.opener', opener);
       return opener;
  };


   $.fn.extend({
       /**
        * 可以让多个相同的元素附加 opener 操作
        * 
        * @param  function send    发送值的函数
        *    function(pjax, opener)
        *        pjax: pjax container
        *        opener: $.pjaxModal.open
        *        this:  打开 pjaxModal 的 <a> 元素
        *        
        *    return: 返回发送的值, 可以不发送值.最终会发送 undefined
        *
        *    可以多次附加,后面附加的会覆盖前面附加的值.
        *        
        * @param  function receive 接收值的函数
        *     function(value, oldValue, pjax, opener)
        *         value: 接收到的值
        *         oldValue: 发送出去的值
        *         pjax: pjax 容器
        *         opener: $.pjaxModal.open
        *         this: 打开 pjaxModal 的 <a> 元素.
        *
        *     可以多次附加, 接收到值之后会顺序调用.
        *     
        * @return this
        */
       openPjaxModal: function(send, receive) {
           this.each(function() {
               var opener = $.pjaxModal.open(this);
               if($.isFunction(send)) { opener.send(send); }
               if($.isFunction(receive)) { opener.receive(receive); }
           });
           return this;
       },
       /**
        * 当 pajxmodal 打开后读取值,并初始化
        * 当点击某个连接的时候, 发送值,然后关闭 pjaxmodal 窗口.
        *
        * @param  function read  读取发送的值
        *   签名: function(value, pjax, listener)
        *       value:  opener 发送的值
        *       pjax: pjax container
        *       listener: 
        *       this: $.fn.listenPjaxModal 
        *       
        *   可以多次调用. 但是在 modal 打开期间,只真正读取一次值,
        *   再次读取值读取到的是缓存的值.
        * 
        * @param  function write 发送响应,然后关闭 pjaxmodal 窗口
        *    签名: function(value, pjax, listener)
        *         value: opener 发送的值
        *         pjax: pjax container
        *         listener:
        *         this: 真正被点击的元素
        *
        * @param boolean close  是否发送并关闭
        *         
        * @return this
        */
       listenPjaxModal: function(read, write, close) {
          if(close && !$.isFunction(write)) {
               write = function(value) { return value; }
          }
          this.each(function() {
              var listener = $.pjaxModal.listen(this);
              $.isFunction(read) && listener.read(read);
              if(close) {
                  listener.writeClose(write);
              } else if($.isFunction(write)) {
                  listener.write(write);
              }
          });
          return this;
       },
       /**
        * 表单提交成功之后,可以立即关闭 pjaxmodal 框并发送值
        * 比如:提交之后渲染这样一个页面:
        * <i id="success">表单提交成功</i>
        * $('success').successPjaxModal({"id": "zhangsan"});
        * 
        * 也可以延迟发送,只需要在第二个参数上设定时间
        * $('success').successPjaxModal({"id": "zhangsan"}, 3000);
        *     这里设定三秒之后发送值.
        * 
        */
       successPjaxModal: function(value, timer) {
          var self = this,
              write = $.isFunction(value) ? value : function() { return value; };
          if(!isNaN(timer)) {
              setTimeout(function() { self.listenPjaxModal(null, write, true); }, timer);
          } else {
              self.listenPjaxModal(null, write, true);
          }
       },
       /**
        * 发生错误后可以直接关闭 pjaxmodal,并提示一个错误消息.
        */
       errorPjaxModal: function(message, timer) {
          var listener = $.pjaxModal.listen(this),
              close    = function() {
                  if(typeof message === 'string') {
                      var msg = message;
                      message = function() { alert(msg); };
                  }
                  listener.close(message);
              };
          return isNaN(timer) ? close() : setTimeout(close, timer);
       }
   });
})(jQuery);
