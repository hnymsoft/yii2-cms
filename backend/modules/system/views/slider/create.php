<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">
            <a href="<?=Yii::$app->request->referrer?>" class="layui-btn layui-btn-primary layui-btn-sm">返回上一页</a>
        </div>
        <div class="layui-card-body">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>添加轮播图</legend>
            </fieldset>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
