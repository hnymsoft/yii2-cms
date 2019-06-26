<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" id="main-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">内容编辑</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <?= $this->render('_form', [
                            'model' => $model,
                            'attachTableModel' => $attachTableModel,
                            'extend_filed' => $extend_filed,
                            'channelDropdown' => $channelDropdown,
                            'thumb_list' => $thumb_list
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

