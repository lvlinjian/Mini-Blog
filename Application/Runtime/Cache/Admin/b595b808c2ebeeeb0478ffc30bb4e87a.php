<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--bootstrap框架 begin-->
    <link href="/Public/Home/images/zebra50.ico" rel="icon" type="image/x-icon" />
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
      }      
    </style>
    <title>斑马缘</title>
  </head>
<body style="background-image:url(/Public/Home/images/bg1.png);">
<!--首页静态导航栏 begin-->
    <!-- Static navbar 首页静态 导航栏 -->
    <nav class="navbar navbar-default navbar-static-top" style="background-color:#99CCCC;">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img class="zebra_logo" src="/Public/Home/images/zebra50.ico">
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
                    <?php if(is_array($_SESSION['second'])): $i = 0; $__LIST__ = $_SESSION['second'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i; if( $vol["pid"] == $vo["id"] && $vol["auth_a"] == 'index' ): ?><li><a class="glyphicon glyphicon-chevron-right" href="/admin/<?php echo ($vol["auth_c"]); ?>/<?php echo ($vol["auth_a"]); ?>.html">&nbsp;<?php echo ($vol["auth_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
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
    <li><a href="<?php echo U('Admin/Index/index');?>">Index</a></li>
    <li class="active">index</li>
  </ol>
<!-- markdown-body -->
<article class="markdown-body">
<!-- 判断是否有等待审核的文章 -->
<?php if($shenhedata["title"] == true): ?><div class="panel">
      <div class="panel-heading">
      <span class="panel-title"><?php echo ($shenhedata["title"]); ?><span class="pull-right">UpDate：<?php echo ($shenhedata["update_time"]); ?></span></span>
      </div>
      <div class="panel-body clearfix"><!-- clearfix清除浮动、pull-left左浮动、pull-right右浮动 -->
      <p class="lead">
        <?php echo ($shenhedata["content"]); ?>
      </p>
      </div>
  </div><?php endif; ?>


<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="panel" style="background-color:#f6f6f6;">
      <div class="panel-heading">
      <span class="panel-title">Title：<a href="<?php echo U('Admin/Index/detail');?>?id=<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a><span class="pull-right">Create：<?php echo ($v["create_time"]); ?> &#9674; 访问量：<?php echo ($v["hits"]); ?></span></span>
      </div>
      <div class="panel-body clearfix"><!-- clearfix清除浮动、pull-left左浮动、pull-right右浮动 -->
      <p class="lead">
        <small>UpDate：<?php echo ($v["update_time"]); ?></small><br>
        <small>Author: <?php echo ($v["nickname"]); ?>&emsp;点赞：<?php echo ($v["zan"]); ?> &emsp;<del>评论：0 </del></small><span class="pull-right"><a href="<?php echo U('Admin/Index/detail');?>?id=<?php echo ($v["id"]); ?>">查看全文</a></span>
        <hr><?php echo ($v["content"]); ?>
      </p>
      </div>
  </div><?php endforeach; endif; else: echo "" ;endif; ?>

</article><!-- end-markdown-body -->
  <br>
  <span class="well well-sm">黑名单文章汇总：</span>
  <hr>
  <div class="list-group">
    <span class="list-group-item disabled"> Cras justo odio</span> 
  </div>

<span class="text-center"><h4><?php echo ($page); ?></h4></span>
</div><!--/.col-xs-12.col-sm-9-->
        

<script type="text/javascript">
// 情景主题数组
var Colors = [];
var ColorArray = [];
for (var i = $('.panel').length - 1; i >= 0; i--) {
    if(ColorArray.length == 0){
        ColorArray = ['success', 'info', 'warning', 'danger'];
    } //, 'primary' 蓝色背景，白色字体不支持响应式，或者说我没找到解决方案
    var rand = Math.floor(Math.random() * ColorArray.length);
    var Color = ColorArray[rand];
    ColorArray.splice(rand,1);
    Colors.push(Color);
}
// 随机主题Color
$(".panel").each(function(index){
      $(this).addClass('panel-' + Colors[index]); 
});         
// 控制富文本内容中较大图片的响应式支持效果
$("div p img").addClass("img-responsive");
// $(".zccode").removeClass("img-responsive");
</script>

<!--右侧菜单栏 begin-->
            <!-- this is 右侧响应式支持 -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">

<!-- 右边侧边栏第1个展区 -->
      <div class="thumbnail" style="background-color:#f6f6f6;">
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
    <div class="thumbnail" style="background-color:#f6f6f6;">
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