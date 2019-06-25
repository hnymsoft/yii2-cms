layui.config({
    base : "js/"
}).use(['form','layer','jquery','upload'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery
        ,upload = layui.upload;

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

    //上传
    upload.render({
        elem: '#upload',
        url: "<?=yii\helpers\Url::to(['/tools/upload'])?>",
        data: {type:'article'},
        done: function(res){
            layer.msg(res.message);
            if(res.status==1){
                $('#slider-pic').val(res.data);
            }
        },
        error: function(){
            layer.msg("请求异常");
        },
        accept: 'images' //只允许上传图片
        ,acceptMime: 'image/*' //只筛选图片
    });

    //图片预览
    $('body').on('click','#view_photo',function () {
        var url = $('#slider-pic').val();
        if(url == ''){
            layer.msg('请上传图片或使用网络图片地址');
            return false;
        }
        var index = layer.open({
            content: '<img src="'+url+'" />'
        });
        layer.full(index);
    })
});