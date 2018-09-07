<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--bootstrap框架 begin-->
    <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/offcanvas.css">
    <script type="text/javascript" src="/Public/bootstrap/js/jq.js"></script>
    <script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/bootstrap/js/offcanvas.js"></script>
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      .zebra_logo{
        width:50px;
      }

      .markdown-body {
        box-sizing: border-box;
        min-width: 200px;
        max-width: 980px;
        margin: 0 auto;
        padding: 45px;
      }
      @media (max-width: 767px) {
        .markdown-body {
          padding: 15px;
        }
      }
      /* 导航鼠标移动效果 */
      .navbar-nav li:hover{
          display: block;
          background: #E2E2E2;         
      }      
    </style>
    <title>斑马缘</title>
  </head>
<body>
<!--首页静态导航栏 begin-->
    <!-- Static navbar 首页静态 导航栏 -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img class="zebra_logo" src="/Public/Home/images/zebra.jpg">
          <a class="navbar-brand glyphicon  glyphicon-home" href="<?php echo U("Admin/Index/index");?>">&nbsp;<?php echo ($_SESSION['manager_info']['nickname']); ?> 的博客</a>
        </div><!-- end navbar-header -->
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a class="glyphicon glyphicon-align-left" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;管理 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php if(is_array($_SESSION['top'])): $k = 0; $__LIST__ = $_SESSION['top'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>&nbsp;<a href="#dropdown-menu<?php echo ($k); ?>" class="nav-header collapsed glyphicon glyphicon-th-list" data-toggle="collapse">&nbsp;<?php echo ($vo["auth_name"]); ?></a>
                  <li class="divider"></li>
                  <ul id="dropdown-menu<?php echo ($k); ?>" class="nav nav-list collapse in">
                    <?php if(is_array($_SESSION['second'])): $i = 0; $__LIST__ = $_SESSION['second'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i; if( $vol["pid"] == $vo["id"] && $vol["auth_a"] == 'index' ): ?><li><a class="glyphicon glyphicon-chevron-right" href="/Admin/<?php echo ($vol["auth_c"]); ?>/<?php echo ($vol["auth_a"]); ?>.html">&nbsp;<?php echo ($vol["auth_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                  </ul><?php endforeach; endif; else: echo "" ;endif; ?>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li role="presentation"><a class="glyphicon glyphicon-home" href=<?php echo U("Home/Index/index");?>>&nbsp;前台</a></li>
            <li id="fat-menu" class="dropdown">
                <a href="#" id="drop3" role="button" class="dropdown-toggle glyphicon glyphicon-cog" data-toggle="dropdown">
                    <i class="icon-user icon-white"></i>
                    <?php echo ($_SESSION['manager_info']['nickname']); ?>
                    <i class="icon-caret-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="glyphicon glyphicon-chevron-right" tabindex="-1" href="/Admin/manager/edit/id/<?php echo ($_SESSION['manager_info']['id']); ?>">&nbsp;修改信息</a></li>
                    <li class="divider"></li>
                    <li><a class="glyphicon glyphicon-chevron-right" tabindex="-1" href="/Admin/login/logout">&nbsp;安全退出</a></li>
                </ul>
            </li>
          </ul>
        </div><!-- end navbar-collapse -->
      </div><!-- end container -->
    </nav><!-- navbar -->

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">菜单</button>
          </p>
          <div class="alert alert-warning" role="alert">系统公告：欢迎体验新UI风格！
            <!-- 添加可关闭的js按键效果 -->
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
<!-- 新模块往这里写 -->
<!-- 博文 情景模块 begin-->
<!-- markdown-body -->
  <!-- 面包屑导航 -->
  <ol class="breadcrumb glyphicon glyphicon-folder-open">
    <li><a href="<?php echo U('Admin/Index/index');?>">Admin</a></li>
    <li><a href="<?php echo U('Admin/Article/index');?>">Article</a></li>
    <li class="active">index</li>
  </ol>
  <div class="panel panel panel-info">
      <div class="panel-heading">
      <span class="panel-title">富文本模式 - lists<span class="pull-right"><a class="btn btn-heading" href="/Admin/Article/add">新增</a></span></span>
      </div>
      <div class="panel-body clearfix"><!-- clearfix清除浮动、pull-left左浮动、pull-right右浮动 -->

        <div class="well">
            <!-- table -->
            <table class="table table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th style="width:50px">序号</th>
                        <th>标题</th>
                        <th style="width:80px">分类</th>
                        <th style="width:20%">时间</th>
                        <th>MD</th>
                        <th style="width:70px">文章状态</th>
                        <th style="width:20%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($data)): $k = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr class="info">
                            <td><?php echo ($v["id"]); ?></td>
                            <td ><a href="<?php echo U('Admin/Index/detail');?>?id=<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a></td>
                            <td><?php echo ($v["cate_name"]); ?></td>
                            <td><?php echo ($v["update_time"]); ?></td>
                            <td><?php echo ($v["md"]); ?></td>
                            <td>
                                <?php if($v["shenhe"] == 0): ?><a href="javascript:void(0);" onclick="if(confirm('审核通过？')) location.href='/Admin/Article/check/id/<?php echo ($v["id"]); ?>/shenhe/1'">待审核</a>
                                <?php elseif($v["shenhe"] == 1): ?>
                                    <a href="javascript:void(0);" onclick="if(confirm('撤销审核状态？')) location.href='/Admin/Article/check/id/<?php echo ($v["id"]); ?>/shenhe/0'">已审核</a>
                                <?php elseif($v["shenhe"] == 2): ?>
                                    <a href="javascript:void(0);" onclick="if(confirm('解密？')) location.href='/Admin/Article/check/id/<?php echo ($v["id"]); ?>/shenhe/0'">已加密</a>
                                <?php elseif($v["shenhe"] == 3): ?>已拉黑
                                <?php else: ?>已删除<?php endif; ?>
                            </td>
                            <td >
                                <a href="/Admin/Article/edit/id/<?php echo ($v["id"]); ?>"> 编辑 </a>&nbsp;
                                <a href="javascript:void(0);" onclick="if(confirm('加个密码锁起来？')) location.href='/Admin/Article/check/id/<?php echo ($v["id"]); ?>/shenhe/2'">加密</a>&nbsp;
                                <a href="javascript:void(0);" onclick="if(confirm('拉进小黑屋打一顿？')) location.href='/Admin/Article/check/id/<?php echo ($v["id"]); ?>/shenhe/3'">拉黑</a>&nbsp;
                                <a href="javascript:void(0);" onclick="if(confirm('确认删除？')) location.href='/Admin/Article/check/id/<?php echo ($v["id"]); ?>/shenhe/4'"> 删除 </a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <!-- pagination -->
            <ul class="pagination">
                <li><a href="#">Prev</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">Next</a></li>
                <!-- class="disabled"  class="active" -->
            </ul>
        </div><!-- well end -->

      </div>
  </div>
</div><!--/.col-xs-12.col-sm-9-->


<!--右侧菜单栏 begin-->
            <!-- this is 右侧响应式支持 -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">

<!-- 右边侧边栏第1个展区 -->
      <div class="thumbnail">
        <img width="100%" src="/Static/cs.jpg" alt="bg:NULL">
        <div class="caption">
          <!-- User Logo Css figure begin -->
          <figure style="width: 100px;height: 100px;margin-left: 25%;margin-top: -25%;">
          <img class="img-circle img-thumbnail" src="/Static/userlogo.png" alt="userlogo">
          </figure>
          <ul class="list-group">
            <h3><li class="list-group-item list-group-item-success glyphicon glyphicon-leaf">&nbsp;博主：<?php echo ($_SESSION['manager_info']['nickname']); ?></li></h3>
            <li class="list-group-item list-group-item-warning glyphicon glyphicon-phone">&nbsp;手机<br>：<?php echo ($_SESSION['manager_info']['phone']); ?></li>
            <li class="list-group-item list-group-item-danger glyphicon glyphicon-send">&nbsp;登录名<br>：<?php echo ($_SESSION['manager_info']['username']); ?></li>
            <li class="list-group-item list-group-item-warning glyphicon glyphicon-envelope">&nbsp;E-mail<br>：<?php echo ($_SESSION['manager_info']['email']); ?></li>
            <li class="list-group-item list-group-item-danger glyphicon glyphicon-time">&nbsp;创建时间<br>：<?php echo ($_SESSION['manager_info']['create_time']); ?></li>
            <li class="list-group-item list-group-item-warning glyphicon glyphicon-time">&nbsp;上次退出时间<br>：<?php echo ($_SESSION['manager_info']['update_time']); ?></li>
          </ul>
        </div>
      </div>

<!-- 我的文章 -->
    <div class="thumbnail">
      <img src="/Static/word1.jpg" alt="我的文章">
      <div class="caption">
        <label class="control-label">我的文章：</label>
        <div>
            <a href="javascript:void(0)">NULL</a><br>
            <a href="javascript:void(0)">NULL</a><br>
            <a href="javascript:void(0)">更多</a>
        </div>
      </div>
    </div>

<!-- end 右1 -->
    <!--右侧菜单栏 end-->


        </div><!--/.sidebar-offcanvas-->
      </div><!--/row row-offcanvas-->

<!-- 底部 begin -->

<footer class="footer" style="clear: both">
  <p>斑马缘：&emsp;<a href=http://www.miitbeian.gov.cn/ target=_blank>京ICP备18012961号-1</a></p>
</footer>
    </div><!--  end container -->
</body>
</html>