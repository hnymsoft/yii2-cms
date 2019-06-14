layui.config({
    base : "js/"
}).use(['form','layer','jquery','laydate','upload'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery;

    $('body').on('click','#login',function () {
        var $form = $('#login-form');
        $.post($form.attr('action'),$form.serialize(),function (data) {
            layer.msg(data.message);
        },'json').fail(function(a,b,c){
            if(a.status==403){
                layer.msg('没有权限');
            }else{
                layer.msg('系统错误');
            }
        });
        return false;
    })
});