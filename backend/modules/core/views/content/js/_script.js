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

});