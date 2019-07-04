layui.config({
	base : "js/"
}).use(['form','layer','jquery'],function(){
	var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		$ = layui.jquery
        ,table = layui.table;

	//查看jq文档
	var url = ["<?= yii\helpers\Url::to(['/tools/jqdoc']); ?>",'yes'];
	$('#open-jqdoc').click(function(){
		layer.open({title:'Jquery参考文档', type: 2, area: ['580px', '530px'], fix: true, maxmin: false, content: url});
	});

    //媒体类型选择
    form.on('radio(is_ref)', function(data){
        console.log(data);
        if(data.value == '1' && data.elem.checked){
            $("#is_ref_url").show();
        }else{
            $("#is_ref_url").hide();
            $("#collect-is_ref_url").val('');
        }
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
});