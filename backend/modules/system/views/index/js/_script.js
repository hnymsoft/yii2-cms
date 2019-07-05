layui.config({
    base: 'js/' //静态资源所在路径
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
        ,height: '320px'
        ,interval:5000,
        //,anim: 'updown' //切换动画方式
    });

    var myChart1 = echarts.init(document.getElementById('echarts_one'));
    var myChart2 = echarts.init(document.getElementById('echarts_two'));
    var myChart3 = echarts.init(document.getElementById('echarts_three'));
    var option1 = '';

    var _this = this;
    //内容发布统计（周）
    $.get("<?=\yii\helpers\Url::toRoute(['ajaxarticlecount'])?>",function(res){
        if(res.status){
            option1 = {
                title: {text: '内容发布统计（周）',left:'center',padding:15},
                tooltip: {trigger: 'axis'},
                grid: {left: '3%',right: '4%',bottom: '3%',containLabel: true},
                xAxis: {name:'发布时间',type: 'category',boundaryGap: false,data: res.data.date},
                yAxis: {name: '发布量',type : 'value'},
                series: [{name:'数量',type:'line',stack: '数量',data:res.data.count}]
            };
            myChart1.setOption(option1);
        }
    },"json").fail(function(a,b,c){
        if(a.status==403){layer.msg('没有权限');}else{layer.msg('系统错误');}
    });

    //模型发布统计（周）
    var option2 = '';
    $.get("<?=\yii\helpers\Url::toRoute(['ajaxmodelcount'])?>",function(res){
        if(res.status){
            option2 = {
                title: {text: '模型发布统计（周）',left:'center',padding:15},
                tooltip: {trigger: 'axis'},
                grid: {left: '3%',right: '4%',bottom: '3%',containLabel: true},
                xAxis: {name:'类型',type: 'category',data: res.data.name,axisTick: {alignWithLabel: true}},
                yAxis: {name: '发布量',type : 'value'},
                series: {name:'数量',type:'bar',barWidth: '50%',data:res.data.count}
            };
            myChart2.setOption(option2);
        }
    },"json").fail(function(a,b,c){
        if(a.status==403){layer.msg('没有权限');}else{layer.msg('系统错误');}
    });

    //模型发布统计（周）
    var option3 = '';
    $.get("<?=\yii\helpers\Url::toRoute(['ajaxusercount'])?>",function(res){
        if(res.status){
            option3 = {
                title: {text: '会员注册统计（周）',left:'center',padding:15},
                tooltip: {trigger: 'axis'},
                grid: {left: '3%',right: '4%',bottom: '3%',containLabel: true},
                xAxis: {name:'日期',type: 'category',data: res.data.date,axisTick: {alignWithLabel: true}},
                yAxis: {name: '注册量',type : 'value'},
                series: {name:'数量',type:'bar',barWidth: '50%',data:res.data.count}
            };
            myChart3.setOption(option3);
        }
    },"json").fail(function(a,b,c){
        if(a.status==403){layer.msg('没有权限');}else{layer.msg('系统错误');}
    });

    //resize监听器
    window.addEventListener("resize",()=>{
        myChart1.resize();
        myChart2.resize();
        myChart3.resize();
    });

    //监听轮播切换事件
    carousel.on('change(echart)', function(){
        myChart1.resize();
        myChart2.resize();
        myChart3.resize();
    });
});