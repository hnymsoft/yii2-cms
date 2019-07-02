layui.config({
	base : "js/"
}).use(['form','layer','jquery'],function(){
	var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		$ = layui.jquery;
		var url = ["<?= yii\helpers\Url::to(['/tools/jqdoc']); ?>",'yes'];
		$('#open-jqdoc').click(function(){
			layer.open({title:'Jquery参考文档', type: 2, area: ['580px', '530px'], fix: true, maxmin: false, content: url});
		});
		
});