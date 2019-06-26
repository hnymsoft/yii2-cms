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
                            <ul class="layadmin-wait layui-text">
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
                                    <table class="layui-table" lay-even>
                                        <colgroup>
                                            <col>
                                            <col width="37.5%">
                                            <col>
                                            <col width="37.5%">
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <td>服务器系统</td>
                                                <td><?=$sysinfo['os']?></td>
                                                <td>Web 服务器</td>
                                                <td><?=$sysinfo['web_server']?></td>
                                            </tr>
                                            <tr>
                                                <td>PHP 版本</td>
                                                <td><?=$sysinfo['php_ver']?></td>
                                                <td>MySQL 版本</td>
                                                <td><?=$sysinfo['mysql_ver']?></td>
                                            </tr>
                                            <tr>
                                                <td>安全模式</td>
                                                <td><?=$sysinfo['safe_mode']?></td>
                                                <td>安全模式GID</td>
                                                <td><?=$sysinfo['safe_mode_gid']?></td>
                                            </tr>
                                            <tr>
                                                <td>Socket 支持</td>
                                                <td><?=$sysinfo['socket']?></td>
                                                <td>时区设置</td>
                                                <td><?=$sysinfo['time_zone']?></td>
                                            </tr>
                                            <tr>
                                                <td>GD 版本</td>
                                                <td><?=$sysinfo['os']?></td>
                                                <td>Zlib 支持</td>
                                                <td><?=$sysinfo['zlib']?></td>
                                            </tr>
                                            <tr>
                                                <td>IP</td>
                                                <td><?=$sysinfo['ip']?></td>
                                                <td>文件上传限制</td>
                                                <td><?=$sysinfo['max_filesize']?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md4">
                            <div class="layui-card">
                                <div class="layui-card-header">开发信息</div>
                                <div class="layui-card-body">
                                    <table class="layui-table" lay-even>
                                        <colgroup>
                                            <col width="130">
                                            <col>
                                        </colgroup>
                                        <tbody>
                                        <tr>
                                            <td>版权所有</td>
                                            <td>小艾</td>
                                        </tr>
                                        <tr>
                                            <td>官方网站</td>
                                            <td>xxx.com</td>
                                        </tr>
                                        <tr>
                                            <td>Git地址</td>
                                            <td><a href="https://github.com/aimitech/yii2-cms" target="_blank" class="layui-text">点击查看>></a></td>
                                        </tr>
                                        <tr>
                                            <td>系统开发</td>
                                            <td>小艾</td>
                                        </tr>
                                        <tr>
                                            <td>开源协议</td>
                                            <td>Apache Licene 2.0</td>
                                        </tr>
                                        <tr>
                                            <td>技术QQ</td>
                                            <td>1596229276</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>