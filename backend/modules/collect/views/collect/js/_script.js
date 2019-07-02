layui.config({
	base : "js/"
}).use(['form','layer','jquery'],function(){
	var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		$ = layui.jquery;

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
		
});