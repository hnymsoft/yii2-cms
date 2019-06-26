<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">栏目添加</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <?= $this->render('_form', [
                            'model' => $model,
                            'channelDropdown' => $channelDropdown
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
