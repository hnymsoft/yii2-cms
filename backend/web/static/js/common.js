/*引入常用模块*/
layui.use(['form','layer','jquery','laydate'], function(){
    var $ = layui.jquery
        ,form = layui.form;

    //添加、编辑（通用）
    form.on('submit(go)', function(data){
        $.ajax({
            url:data.form.action,
            method:'post',
            data:data.field,
            dataType:'json',
            success:function(res){
                layer.msg(res.message);
                if(res.status){
                    location.reload();
                }
            },
            error:function (xhr) {
                layer.msg(xhr.status == 403 ? '没有权限' : '系统错误');
            }
        })
        return false;
    });

    //删除
    $("body").on("click",".layui-default-delete",function(){
        var url = $(this).attr('href');
        var id = $(this).data('id');
        layer.confirm('确定要删除吗？',{icon:3, title:'提示信息'},function(index){
            $.ajax( {
                url: url,
                method: 'POST',
                data: {id:id},
                dataType: 'json',
                success: function(res) {
                    layer.msg(res.message);
                    layer.close(index);
                    if(res.status){
                        location.reload();
                    }
                },
                error: function(res) {
                    if(res.status==403){
                        layer.msg('没有权限');
                    }else{
                        layer.msg('系统错误');
                    }
                }
            });
        });
        return false;
    })
});