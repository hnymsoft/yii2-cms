<?php
use yii\helpers\Html;
$this->params['breadcrumbs'][] = ['label' => '采集管理','url'=>\yii\helpers\Url::toRoute(['collect/index'])];
$this->params['breadcrumbs'][] = ['label' => '采集规则列表','url'=>\yii\helpers\Url::toRoute(['collect/index'])];
$this->params['breadcrumbs'][] = '采集';
?>

<div class="layui-tab layui-tab-brief" id="main-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">采集</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <table class="layui-table">
                <thead><tr><td colspan="2">采集信息</td></tr></thead>
                <tbody>
                    <tr><td width="10%">节点名称</td><td id="subject">--</td></tr>
                    <tr><td width="10%">种子网址数</td><td id="num">--</td></tr>
                </tbody>
            </table>
            <div class="search-box" style="text-align: center">
                <div class="layui-inline btn-group">
                    <?= Html::button('开始采集网页',['class'=>'layui-btn','id'=>'startCollect','style'=>'display:none'])?>
                    <?= Html::button('<i class="layui-icon layui-icon-refresh-3 layui-anim"></i>更新种子网址',['class'=>'layui-btn layui-btn-primary','id'=>'refreshCollect'])?>
                </div>
            </div>
            <div class="collect-progress">
                <div class="subject layui-text">完成当前任务总进度：</div>
                <div class="layui-progress layui-progress-big" lay-showPercent="true" lay-filter="collect">
                    <div class="layui-progress-bar layui-bg-blue" lay-percent="0%"></div>
                </div>
                <div class="info layui-text"></div>
            </div>
            <div class="collect-list">
                <table class="layui-hide" id="collect_list" lay-filter="collect"></table>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="toolbar">
    <div class="layui-btn-container">
        <?=Html::button('<i class="layui-icon layui-icon-delete"></i>批量删除',['class'=>'layui-btn layui-btn-sm layui-btn-danger','lay-event'=>'batDelsCollect'])?>
    </div>
</script>

<?php
$collect_start_url = \yii\helpers\Url::toRoute(['start','id'=>$id]);
$collect_list_url = \yii\helpers\Url::toRoute(['ajaxcollectlist','id'=>$id]);
$collect_del_url = \yii\helpers\Url::toRoute(['ajaxcollectdel','id'=>$id]);
$collect_ref_url = \yii\helpers\Url::toRoute(['ajaxcollectref','id'=>$id]);
$collect_status_url = \yii\helpers\Url::toRoute(['ajaxcollectstatus','id'=>$id]);
$js = <<<JS
layui.config({
	base : "js/"
}).use(['form','layer','jquery','table','element'],function(){
	var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		$ = layui.jquery
        ,table = layui.table
        ,element = layui.element;
	
    table.render({
        id:'collect'
        ,elem: '#collect_list'
        ,url:'$collect_list_url'
        ,toolbar: '#toolbar'
        ,defaultToolbar:['filter','exports']
        ,cols: [[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', title:'ID',width:60,fixed: 'left', unresize: true, sort: true}
            ,{field:'title',title: '标题'}
            ,{field:'name',title: '节点名称'}
            ,{field:'addtime',title: '加入时间'}
            ,{field:'url',title: '源链接'}
        ]]
        ,done: function(res){
            $("#subject").text(res.subject);
            $("#num").text("共 "+res.data.length+" 个种子网址");
            if(res.data.length > 0){
                $("#startCollect").show();
            }
          }
    });
    
    //批量删除
    table.on('toolbar(collect)', function(obj){
        var checkStatus = table.checkStatus(obj.config.id);
        if(obj.event == 'batDelsCollect'){
            var data = checkStatus.data;
            var ids =[];
            data.forEach(function(n,i){
                ids.push(n.id);
            });
            if(ids != ''){
                layer.confirm('确定删除所选项吗？',function (index) {
                    layer.close(index);
                    $.get('$collect_del_url',{ids:ids.join(',')},function(data){
                        layer.msg(data.message);
                        if(data.status){
                            table.reload('collect');
                        }
                    },"json").fail(function(a,b,c){
                        if(a.status==403){
                            layer.msg('没有权限');
                        }else{
                            layer.msg('系统错误');
                        }
                    });
                })
            }else{
                layer.msg('请选择需要删除的行')
            }
        }        
    });
    
    //更新种子列表
    $('body').on('click','#refreshCollect',function() {
        var _this = this;
        $(_this).addClass('layui-btn-disabled').find('i').addClass('layui-anim-rotate layui-anim-loop');
        $.get('$collect_ref_url',function(data){            
            if(data.status){
                table.reload('collect');
            }else{
                layer.msg(data.message);
            }
            $(_this).removeClass('layui-btn-disabled').find('i').removeClass('layui-anim-rotate layui-anim-loop');
        },"json").fail(function(a,b,c){
            if(a.status==403){
                layer.msg('没有权限');
            }else{
                layer.msg('系统错误');
            }
            $(_this).removeClass('layui-btn-disabled').find('i').removeClass('layui-anim-rotate layui-anim-loop');
        });
    })
    
    //采集进度条显示
    var t = setInterval(function() {
      $.ajax({
            async:true,
            url:'$collect_status_url',
            type:"get",
            dataType:"json",
            success:function(res){
                if(res.status == 1){
                    element.progress('collect', res.data+'%');
                    if(res.data > 0){
                        $('.progress').html(res.data+'%');    
                    }else if(res.data == 100){
                        $('.info').show(5000);
                    }
                }
            },
            error:function(a,b,c){
                if(a.status==403){
                    layer.msg('没有权限');
                }
            }
        });   
    },1500)

    //采集
    $('body').on('click','#startCollect',function() {
        $('#startCollect,#refreshCollect').addClass('layui-btn-disabled');
        $('.collect-progress').show();
        $.post('$collect_start_url',function(data,status ,xhr){
            if(data.status == 1){
                $('.info').html(data.message);
            }else{
                layer.msg(data.message);
            }            
        },"json").fail(function(a,b,c){
            if(a.status==403){
                layer.msg('没有权限');
            }else{
                layer.msg('系统错误');
            }
            $('.layui-btn').removeClass('layui-btn-disabled');
        });
    })
});
JS;
$this->registerJs($js);
?>


