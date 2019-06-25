layui.config({
    base : "js/"
}).use(['form','layer','jquery','upload'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery
        ,upload = layui.upload;

    //更新缓存
    $('body').on('click','.cache',function () {
        var _this = this;
        var type = $(_this).data('type');
        $(_this).addClass('layui-btn-disabled').find('i').removeClass('layui-icon-delete').addClass('layui-icon-refresh-3 layui-anim-rotate layui-anim-loop');
        $.post('<?=\yii\helpers\Url::toRoute(["flush"])?>',{type:type},function(data){
            layer.msg(data.message);
            $(_this).removeClass('layui-btn-disabled').find('i').removeClass('layui-icon-refresh-3 layui-anim-rotate layui-anim-loop').addClass('layui-icon-delete');
        },"json").fail(function(a,b,c){
            if(a.status==403){
                layer.msg('没有权限');
            }else{
                layer.msg('系统错误');
            }
            $(_this).removeClass('layui-btn-disabled').find('i').removeClass('layui-icon-refresh-3 layui-anim-rotate layui-anim-loop').addClass('layui-icon-delete');
        });
    })
});