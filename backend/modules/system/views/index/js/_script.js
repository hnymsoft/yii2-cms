layui.config({
    base : "js/"
}).use(['form','layer','jquery','laydate','upload','element','carousel'],function(){
    var form = layui.form
        ,layer = parent.layer === undefined ? layui.layer : parent.layer
        ,$ = layui.jquery
        ,laydate = layui.laydate
        ,upload = layui.upload
        ,element = layui.element
        ,carousel = layui.carousel;

    //建造实例
    carousel.render({
        elem: '#count'
        ,width: '100%' //设置容器宽度
        //,anim: 'updown' //切换动画方式
    });
});