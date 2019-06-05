layui.config({
    base : "js/"
}).use(['form','layer','jquery','laydate','upload'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery
        ,laydate = layui.laydate
        ,upload = layui.upload;

    //日期
    laydate.render({
        elem: '#sdt'
    });
    laydate.render({
        elem: '#edt'
    });

    //上传
    upload.render({
        elem: '#test3',
        url: "<?=yii\helpers\Url::to(['/tools/upload'])?>",
        data: {type:'ad'},
        done: function(res){
            if(res.status==1){
                $('#thumb_box').show().find('img').attr({'src':res.data});
                $('#ad-img_upload').val(res.data);
                layer.msg("上传成功~~");
            }else{
                layer.msg("上传失败~~");
            }
        },
        error: function(){
            layer.msg("请求异常");
        }
    });

    //媒体类型选择
    form.on('select(media)', function(data){
        $(".media_img,.media_font,.media_code,.media_url").hide();
        if(data.value == 1){
            $(".media_font,.media_url").show();
        }else if(data.value == 2){
            $(".media_code").show();
        }else{
            $(".media_img,.media_url").show();
        }
    });
});