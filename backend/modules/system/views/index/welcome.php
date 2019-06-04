<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md4">
                    <div class="layui-card">
                        <div class="layui-card-header">快捷方式</div>
                        <div class="layui-card-body">
                            <ul class="layui-row layui-col-space10 layadmin-shortcut">
                                <li class="layui-col-xs3">
                                    <a lay-href="home/homepage1.html">
                                        <i class="layui-icon layui-icon-console"></i>
                                        <cite>主页一</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="home/homepage2.html">
                                        <i class="layui-icon layui-icon-chart"></i>
                                        <cite>主页二</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="component/layer/list.html">
                                        <i class="layui-icon layui-icon-template-1"></i>
                                        <cite>弹层</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="component/layer/list.html">
                                        <i class="layui-icon layui-icon-template-1"></i>
                                        <cite>弹层</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="home/homepage1.html">
                                        <i class="layui-icon layui-icon-console"></i>
                                        <cite>主页一</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="home/homepage2.html">
                                        <i class="layui-icon layui-icon-chart"></i>
                                        <cite>主页二</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="component/layer/list.html">
                                        <i class="layui-icon layui-icon-template-1"></i>
                                        <cite>弹层</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="component/layer/list.html">
                                        <i class="layui-icon layui-icon-template-1"></i>
                                        <cite>弹层</cite>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md4">
                    <div class="layui-card">
                        <div class="layui-card-header">统计中心</div>
                        <div class="layui-card-body">
                            <ul class="layui-row layui-col-space10 layadmin-backlog">
                                <li class="layui-col-xs6">
                                    <a lay-href="app/content/comment.html" class="layadmin-backlog-body">
                                        <h3>待审评论</h3>
                                        <p><cite>66</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs6">
                                    <a lay-href="app/forum/list.html" class="layadmin-backlog-body">
                                        <h3>待审帖子</h3>
                                        <p><cite>12</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs6">
                                    <a lay-href="template/goodslist.html" class="layadmin-backlog-body">
                                        <h3>待审商品</h3>
                                        <p><cite>99</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs6">
                                    <a href="javascript:;" onclick="layer.tips('不跳转', this, {tips: 3});" class="layadmin-backlog-body">
                                        <h3>待发货</h3>
                                        <p><cite>20</cite></p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md4">
                    <div class="layui-card">
                        <div class="layui-card-header">待办事项</div>
                        <div class="layui-card-body">
                            <ul class="layadmin-wait">
                                <li><a href="">修复开启 isLazyimg:true 后, 图片懒加载但</a></li>
                                <li><a href="">修复开启 isLazyimg:true 后, 图片懒加载但</a></li>
                                <li><a href="">修复开启 isLazyimg:true 后, 图片懒加载但</a></li>
                                <li><a href="">修复开启 isLazyimg:true 后, 图片懒加载但</a></li>
                                <li><a href="">修复开启 isLazyimg:true 后, 图片懒加载但</a></li>
                                <li><a href="">修复开启 isLazyimg:true 后, 图片懒加载但</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">数据概览</div>
                        <div class="layui-card-body">

                        </div>
                    </div>
                </div>

                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">系统信息</div>
                        <div class="layui-card-body">
                            <div class="layui-row">
                                <div class="layui-col-md4">服务器操作系统：<?=$sysinfo['os']?></div>
                                <div class="layui-col-md4">Web 服务器：<?=$sysinfo['web_server']?></div>
                                <div class="layui-col-md4">PHP 版本：<?=$sysinfo['php_ver']?></div>
                                <div class="layui-col-md4">MySQL 版本：<?=$sysinfo['mysql_ver']?></div>
                                <div class="layui-col-md4">安全模式：<?=$sysinfo['safe_mode']?></div>
                                <div class="layui-col-md4">安全模式GID：<?=$sysinfo['safe_mode_gid']?></div>
                                <div class="layui-col-md4">Socket 支持：<?=$sysinfo['socket']?></div>
                                <div class="layui-col-md4">时区设置：<?=$sysinfo['time_zone']?></div>
                                <div class="layui-col-md4">GD 版本：<?=$sysinfo['os']?></div>
                                <div class="layui-col-md4">Zlib 支持：<?=$sysinfo['zlib']?></div>
                                <div class="layui-col-md4">IP：<?=$sysinfo['ip']?></div>
                                <div class="layui-col-md4">文件上传的最大大小：<?=$sysinfo['max_filesize']?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>