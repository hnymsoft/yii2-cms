<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->registerJs($this->render('js/_script.js'));
?>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">网站前台缓存</div>
        <div class="layui-card-body">
            <div class="layui-btn-group">
                <button type="button" class="layui-btn layui-btn-normal cache" data-type="f_cache"><i class="layui-icon layui-icon-delete layui-anim"></i>前台缓存</button>
<!--                <button type="button" class="layui-btn layui-btn-normal cache" data-type="f_redis"><i class="layui-icon layui-icon-delete layui-anim"></i>Redis缓存</button>-->
                <button type="button" class="layui-btn layui-btn-warm cache" data-type="f_logs"><i class="layui-icon layui-icon-delete layui-anim"></i>Logs日志</button>
            </div>
        </div>
    </div>

    <div class="layui-card">
        <div class="layui-card-header">网站后台缓存</div>
        <div class="layui-card-body">
            <div class="layui-btn-group">
                <button type="button" class="layui-btn layui-btn-normal cache" data-type="b_cache"><i class="layui-icon layui-icon-delete layui-anim"></i>后台缓存</button>
                <button type="button" class="layui-btn layui-btn-warm cache" data-type="b_logs"><i class="layui-icon layui-icon-delete layui-anim"></i>Logs日志</button>
            </div>
        </div>
    </div>

    <div class="layui-card">
        <div class="layui-card-header">Schema缓存</div>
        <div class="layui-card-body">
            <div class="layui-btn-group">
                <button type="button" class="layui-btn layui-btn-normal cache" data-type="schema"><i class="layui-icon layui-icon-delete layui-anim"></i>数据表缓存</button>
            </div>
        </div>
    </div>

    <div class="layui-card">
        <div class="layui-card-header">全部缓存</div>
        <div class="layui-card-body">
            <div class="layui-btn-group">
                <button type="button" class="layui-btn layui-btn-danger cache" data-type="all"><i class="layui-icon layui-icon-delete layui-anim"></i>一键清空</button>
            </div>
        </div>
    </div>
</div>

