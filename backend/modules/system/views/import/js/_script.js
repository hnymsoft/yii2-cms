layui.config({
    base : "js/"
}).use(['form','layer','jquery','laydate','upload'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery;

    //还原
    $('body').on('click','#restore',function () {
        var _this = this;
        $(_this).addClass('layui-btn-disabled').find('span').addClass('layui-anim-rotate layui-anim-loop').show();
        $.post($(_this).attr('href'),function(data){
            layer.msg(data.message);
            if(data.status){
                location.reload();
            }
            $(_this).removeClass('layui-btn-disabled').find('span').removeClass('layui-anim-rotate layui-anim-loop').hide();
        },"json").fail(function(a,b,c){
            if(a.status==403){
                layer.msg('没有权限');
            }else{
                layer.msg('系统错误');
            }
            $(_this).removeClass('layui-btn-disabled').find('span').removeClass('layui-anim-rotate layui-anim-loop').hide();
        });
        return false;
    })

    $('body').on('click','#delete',function () {
        var _this = this;
        $.post($(_this).attr('href'),function(data){
            layer.msg(data.message);
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
        return false;
    })
});