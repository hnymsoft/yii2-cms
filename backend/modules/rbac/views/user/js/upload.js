layui.use(['upload','layer'], function(){
  var upload = layui.upload,layer = parent.layer === undefined ? layui.layer : parent.layer;

    upload.render({
        elem: '#upload',
        url: "<?=yii\helpers\Url::to(['/tools/upload'])?>",
        done: function(res){
            if(res.status==1){
                //编辑上传成功后需要编辑的地方
                $("#signup-head_pic").val(res.data);
                $("#user-head_pic").val(res.data);
                $(".userinfo_head_pic").attr('src',res.data);
                //编辑父窗口数据
                parent.$('.header_user_head_pic').attr('src',res.data);
                layer.msg("上传成功");
            }else{
                layer.msg("上传失败");
            }
        },
        error: function(){
            layer.msg("请求异常");
        }
    });
});