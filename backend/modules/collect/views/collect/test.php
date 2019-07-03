<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this"><?=$subject?> - 采集测试（本次共采集（<?=count($data)?>）条数据）</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <pre><?php print_r($data)?></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

