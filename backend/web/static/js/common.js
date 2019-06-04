layui.config({
    base: '../../layuiadmin/' //静态资源所在路径
}).extend({
    index: 'lib/index', //主入口模块
}).use('index');

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
});