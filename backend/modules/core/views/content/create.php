<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'attachTableModel' => $attachTableModel,
                'extend_filed' => $extend_filed,
                'channelDropdown' => $channelDropdown
            ]) ?>
        </div>
    </div>
</div>
