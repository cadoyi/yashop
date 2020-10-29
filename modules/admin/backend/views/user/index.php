<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * 
 */
$this->title = '管理用户';
$this->registerJsVar('dataUrl', Url::to(['/admin/user/data']));
?>
<form class="layui-form">
    <div class="layui-input-inline mt-2">
            <input id="username_input"
                type="text" 
                name="username" 
                placeholder="搜索用户名" 
                autocomplete="off" 
                class="layui-input" 
            />
    </div>
    <div class="layui-input-inline mt-2">
        <input 
            id="nickname-input"
            type="text" 
            name="nickname" 
            placeholder="搜索昵称" 
            autocomplete="off" 
            class="layui-input" 
        />
    </div>
    <div class="layui-input-inline mt-2">
        <select id="is_active_input" name="is_active" placeholder="用户状态">
            <option value="">选择用户状态</option>
            <option value="0">已禁用</option>
            <option value="1">已启用</option>
        </select>
    </div>
    <div class="layui-input-inline mt-2">
        <button id="button_search" class="layui-btn">搜索</button>
    </div>
</form>

<table id="userlist" lay-filter="userlist"></table>
<script type="text/html" id="avatarTpl">
    <img src="{{d.avatar}}" />    
</script>
<script type="text/html" id="actions">
    <a class="layui-btn layui-btn-sm" href="<?= Url::to(['edit'])?>?id={{d.id}}">编辑</a>
</script>

<?php $this->beginScript() ?>
<script>
    layui.form.render();
    var table = layui.table.render({
        elem: "#userlist",
        url: dataUrl,
        page: true,
        cellMinWidth : 95,
        height: $('#layui_body').height(),
        limit: 20,
        limits: [1, 10, 20,30,40,50],
        cols: [[
            {field: 'id', title: 'ID', width: 80, sort: true, fixed: 'left'},
            {field: 'avatar', title: '头像', templet: '#avatarTpl', width: 80},            
            {field: 'username', title: '用户名', sort: true, width: 120},
            {field: 'nickname', title: '昵称', width: 120},
            {field: 'is_active', title: '激活', width: 120},
            {field: 'created_at', title: '加入时间', width: 180},
            {field: 'updated_at', title: '更新时间', width: 180},
            {title: '操作', fixed: 'right', templet: "#actions"}
        ]]
    });
    $('#button_search').on('click', function( e ) {
        e.preventDefault();
        table.reload({
            page: {
                curr: 1 //重新从第 1 页开始
            },
            where: {
                username: $("#username_input").val(),
                nickname: $("#nickname-input").val(),
                is_active: $("#is_active_input").val(),
            }
        });
    });
</script>
<?php $this->endScript() ?>