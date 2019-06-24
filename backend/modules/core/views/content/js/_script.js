layui.config({
    base : "js/"
}).use(['form','layer','jquery','laydate','upload','element'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery
        ,laydate = layui.laydate
        ,upload = layui.upload
        ,element = layui.element;

        //日期时间选择器
        laydate.render({
            elem: '#pubdate_addtime'
            ,type: 'datetime'
        });

    //上传
    upload.render({
        elem: '#upload',
        url: "<?=yii\helpers\Url::to(['/tools/upload'])?>",
        data: {type:'article'},
        done: function(res){
            layer.msg(res.message);
            if(res.status==1){
                $('#content-thumb').val(res.data);
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
        var url = $('#content-thumb').val();
        if(url == ''){
            layer.msg('请上传图片或使用网络图片地址');
            return false;
        }
        var index = layer.open({
            content: '<img src="'+url+'" />'
        });
        layer.full(index);
    })

    //多图片上传
    upload.render({
        elem: '#batUpload'
        ,url: "<?=yii\helpers\Url::to(['/tools/upload'])?>"
        ,data: {type:'pic'}
        ,multiple: true
        ,before: function(obj){
            //预读本地文件示例，不支持ie8
            // obj.preview(function(index, file, result){
            //     $('#batUploadList').append('<div><img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img"><span>删除</span></div>');
            // });
        }
        ,done: function(res){
            layer.msg(res.message);
            if(res.status){
                $('#batUploadList').append('<div><img src="/'+ res.data +'" alt="图集" class="layui-upload-img"><span data-src="'+res.data+'">删除</span></div>');

                //赋值
                var img_list = $('#attachtable-imgurls').val();
                $('#attachtable-imgurls').val(img_list + res.data + '|');
            }
        },
        error: function(){
            layer.msg("请求异常");
        },
        accept: 'images' //只允许上传图片
        ,acceptMime: 'image/*' //只筛选图片
    });

    //删除图片
    $('.layui-upload').on('click','span',function () {
        var _this = this;
        var file = $(_this).data('src');
        $.post("<?=yii\helpers\Url::to(['/tools/del-file'])?>",{file:file},function(data){
            layer.msg(data.message);
            if(data.status){
                $(_this).parents('#batUploadList div').remove();

                //赋值
                var img_list = $('#attachtable-imgurls').val();
                $('#attachtable-imgurls').val(img_list.replace(file+'|',''));
            }
        },"json").fail(function(a,b,c){
            if(a.status==403){
                layer.msg('没有权限');
            }else{
                layer.msg('系统错误');
            }
        });
    });

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

    //媒体类型选择
    form.on('checkbox(flag)', function(data){
        console.log(data);
        if(data.value == 'r' && data.elem.checked){
            $("#redirect").show();
        }else{
            $("#redirect").hide();
        }
    });
});