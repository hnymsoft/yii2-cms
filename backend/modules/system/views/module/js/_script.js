layui.config({
    base : "js/"
}).use(['form','layer','jquery','upload'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery;

    //监听指定开关
    form.on('switch(status)', function(data){
        var status = (this.checked) ? 1 : 0;
        var _this = this;
        $.post($(_this).data('url'),{status:status},function(data){
            //layer.msg(data.message);
            if(data.status){
                location.reload();
            }
        },"json").fail(function(a,b,c){
            if(a.status==403){
                layer.msg('没有权限');
            }else{
                layer.msg('系统错误');
            }
        });
    });
});