layui.config({
    base : "layuiadmin/layui/lay/modules/"
}).extend({
    treetable: 'treetable-lay/treetable'
}).use(['form','layer','jquery','table','treetable'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery
        ,table = layui.table
        ,treetable = layui.treetable;

    // 渲染表格
    var renderTable = function () {
        treetable.render({
            treeColIndex: 1,//树形图标显示在第几列
            treeSpid: 0,//最上级的父级id
            treeIdName: 'id',//id字段的名称
            treePidName: 'p_id',//pid字段的名称
            treeDefaultClose: false,//是否默认折叠
            treeLinkage: true,//父级展开时是否自动展开所有子级
            showCheckbox: false,
            elem: '#channel',
            url: '<?=\yii\helpers\Url::toRoute(['channel/ajaxchannellist'])?>',
            page: false,
            cols: [[
                //{type: 'checkbox'},
                {field: 'id', title: 'ID',width:70,align: 'center'},
                {field: 'name', title: '栏目名称'},
                {field: 'm_name',title:'模型', width:150,align: 'center'},
                {field: 'list_tpl', title: '列表模版'},
                {field: 'content_tpl', title: '内容模版'},
                {field: 'order', title: '排序', width:120,align: 'center',
                    templet: function(data){
                        return '<input type="text" name="order[]" value="'+data.order+'" lay-event="order" class="layui-input order" style="width:50px;height: 28px;text-align:center;text-indent: 0;padding:0" />';
                    }
                },
                {field: 'status', title: '状态', width:120,align: 'center',event:'status',
                    templet: function(data){
                        var status = data.status == 1 ? 'checked' : '';
                        return '<input type="checkbox" name="close" lay-skin="switch" lay-text="启用|禁用" '+status+'>';
                    }
                },
                {templet: btn, title: '操作',width:150,align: 'center'}
            ]],
            done: function () {
                layer.closeAll('loading');
            }
        });
    };

    //渲染table
    renderTable();

    //操作按钮
    function btn(data){//操作中显示的内容
        return [
            "<a class='layui-btn layui-btn-normal layui-btn-xs' lay-event='edit' href='javascript:;'>编辑</a>",
            "<a class='layui-btn layui-btn-danger layui-btn-xs' lay-event='delete' href='javascript:;'>删除</a>",
        ].join('');
    }

    //删除
    function del(id){
        var url = '<?=\yii\helpers\Url::toRoute(["delete"])?>'+'&id='+id;
        var _this = this;
        $.post(url,function(data){
            layer.msg(data.message);
            if(data.status){
                renderTable();
            }
        },"json").fail(function(a,b,c){
            if(a.status==403){
                layer.msg('没有权限');
            }else{
                layer.msg('系统错误');
            }
        });
    }

    //监听工具条
    table.on('tool(channel)', function (obj) {
        var data = obj.data;
        var layEvent = obj.event;
        if (layEvent === 'delete') {
            del(data.id);
        }else if (layEvent === 'edit') {
            location.href = "/index.php?r=system/channel/update&id="+data.id;
        }else if(layEvent == 'order'){
            layer.prompt({
                formType: 3
                ,title: '修改['+ data.name +']的栏目顺序'
                ,value: data.order
            }, function(value, index){
                layer.close(index);
                var url = '<?=\yii\helpers\Url::toRoute(["ajaxorder"])?>'+'&id='+data.id+'&order='+value;
                var _this = this;
                $.get(url,function(data){
                    layer.msg(data.message);
                    if(data.status){
                        renderTable();
                    }
                },"json").fail(function(a,b,c){
                    if(a.status==403){
                        layer.msg('没有权限');
                    }else{
                        layer.msg('系统错误');
                    }
                });
            });
        }else if(layEvent == 'status'){
            var status = data.status == 1 ? 0 : 1;
            var url = '<?=\yii\helpers\Url::toRoute(["ajaxstatus"])?>'+'&id='+data.id+'&status='+status;
            var _this = this;
            $.get(url,function(data){
                layer.msg(data.message);
                if(data.status){
                    renderTable();
                }
            },"json").fail(function(a,b,c){
                if(a.status==403){
                    layer.msg('没有权限');
                }else{
                    layer.msg('系统错误');
                }
            });
        }
    });

    //搜索
    $('body').on('click','#btn-search',function(){
        var keyword = $('.search_input').val();
        var searchCount = 0;
        $('#channel').next('.treeTable').find('.layui-table-body tbody tr td').each(function () {
            $(this).css('background-color', 'transparent');
            var text = $(this).text();
            if (keyword != '' && text.indexOf(keyword) >= 0) {
                $(this).css('background-color', 'rgba(250,230,160,0.5)');
                if (searchCount == 0) {
                    treetable.expandAll('#auth-table');
                    $('html,body').stop(true);
                    $('html,body').animate({scrollTop: $(this).offset().top - 150}, 500);
                }
                searchCount++;
            }
        });
        if (keyword == '') {
            layer.msg("请输入搜索内容~");
        } else if (searchCount == 0) {
            layer.msg("没有匹配结果~");
        }
    });
});