<?php
$this->registerJs($this->render('js/_script.js'));
?>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md4">
                    <div class="layui-card">
                        <div class="layui-card-header">快捷方式</div>
                        <div class="layui-card-body">
                            <ul class="layui-row layui-col-space10 layadmin-shortcut">
                                <?php if(!empty($model)):?>
                                    <?php $icon = [
                                        'layui-icon-list',
                                        'layui-icon-picture-fine',
                                        'layui-icon-cart',
                                        'layui-icon-tabs',
                                        'layui-icon-form',
                                        'layui-icon-layouts',
                                        'layui-icon-group',
                                        'layui-icon-file'
                                    ]?>
                                    <?php foreach ($model as $key => $val):?>
                                    <li class="layui-col-xs3">
                                        <a href="<?=\yii\helpers\Url::toRoute(['/core/content/index','m_id'=>$val['id']])?>">
                                            <i class="layui-icon <?=$icon[$key]?>"></i>
                                            <cite><?=$val['name']?> (<?=$val['count']?>)</cite>
                                        </a>
                                    </li>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md4">
                    <div class="layui-card">
                        <div class="layui-card-header">待办事项</div>
                        <div class="layui-card-body">
                            <ul class="layui-row layui-col-space10 layadmin-backlog">
                                <li class="layui-col-xs6">
                                    <a lay-href="app/content/comment.html" class="layadmin-backlog-body">
                                        <h3>最新文章</h3>
                                        <p><cite><?=$arc_count?></cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs6">
                                    <a lay-href="app/forum/list.html" class="layadmin-backlog-body">
                                        <h3>未审核文章</h3>
                                        <p><cite><?=$arc_audit_count?></cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs6">
                                    <a href="<?=\yii\helpers\Url::toRoute(['/system/guestbook/index'])?>" class="layadmin-backlog-body">
                                        <h3>最新留言</h3>
                                        <p><cite><?=$gb_count?></cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs6">
                                    <a href="<?=\yii\helpers\Url::toRoute(['/system/guestbook/index'])?>" class="layadmin-backlog-body">
                                        <h3>未审核评论</h3>
                                        <p><cite><?=$gb_audit_count?></cite></p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md4">
                    <div class="layui-card">
                        <div class="layui-card-header">最新文档</div>
                        <div class="layui-card-body">
                            <ul class="layadmin-wait">
                                <?php if(!empty($list)):?>
                                    <?php foreach ($list as $key => $val):?>
                                        <li><span style="float: right"><?=date('Y-m-d',strtotime($val['create_addtime']))?></span><a href="javascript:;"><?=$val['title']?></a></li>
                                    <?php endforeach?>
                                <?php else:?>
                                    <li>暂无内容~~</li>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">数据概览</div>
                        <div class="layui-card-body">
                            <div id="count" class="layui-carousel layadmin-carousel" data-anim="fade">
                                <div carousel-item>
                                    <div>1</div>
                                    <div>2</div>
                                    <div>3</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="layui-col-md12">
                    <div class="layui-row layui-col-space15">
                        <div class="layui-col-md8">
                            <div class="layui-card">
                                <div class="layui-card-header">系统信息</div>
                                <div class="layui-card-body">
                                    <div class="layui-row">
                                        <div class="layui-col-md6">服务器操作系统：<?=$sysinfo['os']?></div>
                                        <div class="layui-col-md6">Web 服务器：<?=$sysinfo['web_server']?></div>
                                        <div class="layui-col-md6">PHP 版本：<?=$sysinfo['php_ver']?></div>
                                        <div class="layui-col-md6">MySQL 版本：<?=$sysinfo['mysql_ver']?></div>
                                        <div class="layui-col-md6">安全模式：<?=$sysinfo['safe_mode']?></div>
                                        <div class="layui-col-md6">安全模式GID：<?=$sysinfo['safe_mode_gid']?></div>
                                        <div class="layui-col-md6">Socket 支持：<?=$sysinfo['socket']?></div>
                                        <div class="layui-col-md6">时区设置：<?=$sysinfo['time_zone']?></div>
                                        <div class="layui-col-md6">GD 版本：<?=$sysinfo['os']?></div>
                                        <div class="layui-col-md6">Zlib 支持：<?=$sysinfo['zlib']?></div>
                                        <div class="layui-col-md6">IP：<?=$sysinfo['ip']?></div>
                                        <div class="layui-col-md6">文件上传的最大大小：<?=$sysinfo['max_filesize']?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md4">
                            <div class="layui-card">
                                <div class="layui-card-header">开发信息</div>
                                <div class="layui-card-body">
                                    <div class="layui-row">
                                        <div class="layui-col-md12">版权所有：<span style="float: right">小艾</span></div>
                                        <div class="layui-col-md12">官方网站：<span style="float: right">xxx.com</span></div>
                                        <div class="layui-col-md12">Git地址：<span style="float: right"><a href="https://github.com/aimitech/yii2-cms" target="_blank">点击查看</a></span></div>
                                        <div class="layui-col-md12">系统开发：<span style="float: right">小艾</span></div>
                                        <div class="layui-col-md12">开源协议：<span style="float: right">Apache Licene 2.0</span></div>
                                        <div class="layui-col-md12">技术QQ：<span style="float: right">1596229276</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>