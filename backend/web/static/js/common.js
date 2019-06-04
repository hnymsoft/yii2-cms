layui.config({
    base: '../../layuiadmin/' //静态资源所在路径
}).extend({
    index: 'lib/index', //主入口模块
}).use('index');

/*引入常用模块*/
layui.use(['form','layer','jquery','laydate'], function(){
    var $ = layui.jquery
        ,form = layui.form;

    $("#prev").click(function () {
        history.go(-1);
    })
});