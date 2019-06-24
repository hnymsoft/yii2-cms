layui.config({
    base : "js/"
}).use(['form','layer','jquery','laydate','upload'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery;

    //优化
    $('body').on('click','#optimize',function () {
        var href = $(this).attr("href");
        $.post(href,function(data){
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

    //修复
    $('body').on('click','#repair',function () {
        var href = $(this).attr("href");
        $.post(href,function(data){
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

    //备份
    $('body').on('click','#backup',function () {
        var _this = this;
        if ($('#grid-view').yiiGridView('getSelectedRows').length <= 0) {
            layer.msg('请选择要备份的表');
            return false;
        }
        $(_this).addClass('layui-btn-disabled').find('span').addClass('layui-anim-rotate layui-anim-loop').show();
        var form = $("#export-form");
        $.post(form.attr('action'),form.serialize(),function(data){
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
    })

    form.on('checkbox(allChoose)', function(data){
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
        child.each(function(index, item){
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });
});