<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
use common\assets\JsTreeAsset;
JsTreeAsset::register($this);

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $self catalog\backend\vms\category\Tree
 *
 * 
 */
$this->registerJsVar('loadUrl', Url::to(['load', 'c' => $category->id ], true));
$this->registerJsVar('createUrl', Url::to(['create', 'c' => $category->id], true));
$this->registerJsVar('deleteUrl', Url::to(['delete', 'c' => $category->id], true));
$this->registerJsVar('updateUrl', Url::to(['update', 'c' => $category->id], true));
$this->registerJsVar('sortUrl', Url::to(['sort', 'c' => $category->id], true));
$this->registerJsVar('contentUrl', Url::to(['/issue/content/index'], true));

$this->addBreadcrumb($category->title, ['/issue/category/index']);
$this->title = Yii::t('app', 'Manage menus');
?>


<div class="d-flex">
    <div class="my-3 px-3">
        <div><a id="add_root_menu" class="btn btn-sm btn-molv" href="#">添加主菜单</a></div>
        <div id="menu_container" class="menu-container"></div>
    </div>
    <div id="content_container" class="flex-grow-1 border-left">
        
    </div>
</div>
<?php $this->beginScript() ?>
<script>
    var sortNodes = function( inst, node, up ) {
        var prev, next, sorts = [];
        sorts.push( node.id );
        if( up ) {
            prev = inst.get_prev_dom(node, true);
            if(!prev.length) {
                return;
            }

            inst.cut(node);
            inst.paste(prev, 'before');
            next = prev;
            prev = inst.get_prev_dom(node, true);            
        } else {
            next = inst.get_next_dom(node, true);
            if(!next.length) {
                return;
            }
            inst.cut(node);
            inst.paste(next, 'after');
            prev = next;
            next = inst.get_next_dom(node, true);
        }        
        while(prev.length) {
            var pnode = inst.get_node(prev);
            sorts.unshift(pnode.id);
            prev = inst.get_prev_dom(pnode, true);
        }
        while(next.length) {
            var nnode = inst.get_node(next);
            sorts.push(nnode.id);
            next = inst.get_next_dom(nnode, true);
        }
        
        return $.post(sortUrl, {
            'ids': sorts,
        }).then(function( res ) {
            if(res.error) {
                op.alert(res.message);
                inst.refresh();
                return;
            }
            op.success();
        }, function( ) {
            op.alert('网络错误！');
        });
    };

    var getEditCallback = function( inst, obj) {
        return function(node, status, cancel) {
            var originalText = node.original.text;
            if(status) {
                $.post(updateUrl, {
                    id: node.id,
                    title: node.text
                }).then(function( res ) {
                    if(res.error) {
                        op.alert(res.message);
                        inst.rename_node(obj, originalText);
                    }
                    op.success();
                }, function() {
                    op.alert('网络错误');
                    inst.rename_node(obj, originalText);
                });
            }
        };
    };


    $('#menu_container').jstree({
        'core': {
            "check_callback": true,
            "multiple": false,
            'data': {
               'url': loadUrl,
                'data': function( node ) {
                    return { 'id': node.id };
                }                
            }
        },
        "contextmenu": {
            "select_node": false,
            "items": function() {
                return {
                    "create" : {
                        "separator_before"  : false,
                        "separator_after"   : false,
                        "_disabled"         : false,
                        'icon'              : "fa fa-plus",
                        "label"             : "添加子菜单",
                        "action"            : function (data) {
                            var inst = $.jstree.reference(data.reference),
                                obj = inst.get_node(data.reference);
                                $.post(createUrl, {
                                    parent: obj.id
                                }).then(function( res ) {
                                    if(res.error) {
                                         op.alert(res.message);
                                         return;
                                    }
                                    var node = res.data;
                                    inst.create_node(obj, node, 'last', function( new_node ) {
                                        var callback = getEditCallback(inst, node);
                                         try {
                                            inst.edit(new_node,new_node.text, callback);
                                         } catch( ex ) {
                                             setTimeout(function() {
                                                 inst.edit(new_node, new_node.text, callback);
                                             }, 0);
                                         }
                                    });
                                }, function() {
                                    alert('网络错误！');
                                });
                        }
                    },
                    "rename" : {
                        "separator_before"  : false,
                        "separator_after"   : false,
                        "_disabled"         : false,
                        'icon'              : "fa fa-pencil",
                        "label"             : "重命名",
                        "action"            : function (data) {
                            var inst = $.jstree.reference(data.reference),
                                obj = inst.get_node(data.reference);
                            var text = obj.text;
                            inst.edit(obj, text, getEditCallback(inst, obj));
                        }
                    },
                    "remove" : {
                        "separator_before"  : false,
                        "icon"              : 'fa fa-trash',
                        "separator_after"   : false,
                        "_disabled"         : false, 
                        "label"             : "删除",
                        "action"            : function (data) {
                            var inst = $.jstree.reference(data.reference),
                                obj = inst.get_node(data.reference);                            
                            if(!confirm('确定要删除吗？ ')) {
                                return;
                            }
                            $.post(deleteUrl, {
                                'id': obj.id
                            }).then(function(res){
                                if(res.error) {
                                    op.alert(res.message);
                                } else {
                                    if(inst.is_selected(obj)) {
                                        inst.delete_node(inst.get_selected());
                                    }
                                    else {
                                        inst.delete_node(obj);
                                    } 
                                    op.success();                                   
                                }
                            }, function() {
                                alert('网络错误');
                            });
                        }
                    },
                    'move': {
                        "separator_before": false,
                        "separator_after": false,
                        "icon": "fa fa-sort",
                        "label": "移动",
                        "submenu": [
                            {
                                "separator_before": false,
                                "separator_after": false,
                                "label": "上移",
                                "icon": "fa fa-long-arrow-up",
                                "action": function( data ) {
                                    var inst = $.jstree.reference(data.reference);
                                    var node = inst.get_node(data.reference);
                                    sortNodes(inst, node, true);
                                }
                            },
                            {
                                "label": "下移",
                                "icon": "fa fa-long-arrow-down",
                                "action": function( data ) {
                                    var inst = $.jstree.reference(data.reference);
                                    var node = inst.get_node(data.reference);
                                    sortNodes(inst, node, false);
                                }
                            }
                        ]
                        
                    },
                    'issues': {
                        'label': '管理问题',
                        'icon': 'fa fa-cog',
                        'action': function( data ) {
                            var inst = $.jstree.reference(data.reference);
                            var node = inst.get_node(data.reference);
                            location.href = contentUrl + '?mid=' + node.id;
                        }
                    }
                };
            }
        },
        'plugins': [ 'contextmenu' ]
    }).on('ready.jstree', function( e ) {
         $(this).jstree(true).open_all();
    });
    /* .on('select_node.jstree', function( e, data) {
         var node = data.node;
         var id = node.id;
         var category_id = node.original.category_id;
         var url = contentUrl + '?mid=' + id;
         $.get(url, function( res ) {
            $('#content_container').html(res);
         });
    }); */


    $('#add_root_menu').on('click', function( e ) {
        stopEvent(e);
        var inst = $('#menu_container').jstree(true);
        var obj = inst.get_node($.jstree.root);
        $.post(createUrl, {
            parent: obj.id,
        }).then(function( res ) {
            if(res.error) {
                 op.alert(res.message);
                 return;
            }
            var node = res.data;
            inst.create_node(obj, node, 'last', function( new_node ) {
                var callback = getEditCallback(inst, node);
                 try {
                    inst.edit(new_node, new_node.text, callback);
                 } catch( ex ) {
                     setTimeout(function() {
                         inst.edit(new_node, new_node.text, callback);
                     }, 0);
                 }
            });
        }, function() {
            alert('网络错误！');
        });
    });
</script>
<?php $this->endScript() ?>