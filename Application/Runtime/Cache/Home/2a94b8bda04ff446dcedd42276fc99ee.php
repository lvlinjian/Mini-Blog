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
    <!-- 引入 github-markdown.css 样式 -->
    <link rel="stylesheet" type="text/css" href="/Public/md/github-markdown.css">
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
    <!-- 百度云观测 http://www.miniblog.top/ -->
    <meta baidu-gxt-verify-token="e95e5061c6305eff6dc954d9969fa1a9">
    <!-- 域名证书验证 https://miniblog.top/ -->
    <meta baidu-gxt-verify-token="2690630927c254c8c3696bc786eda2af">
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

          <?php if($_SESSION['manager_info']['nickname']== false): ?><a class="navbar-brand glyphicon glyphicon-home" href="<?php echo U("Home/Index/index");?>">&nbsp;斑马缘</a>
          <?php else: ?>
            <a class="navbar-brand glyphicon  glyphicon-home" href="<?php echo U("Home/Index/index");?>">&nbsp;<?php echo ($_SESSION['manager_info']['nickname']); ?> 的博客</a><?php endif; ?>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a class="glyphicon glyphicon-user" href="https://github.com/lvlinjian/Mini-Blog">&nbsp;关于</a></li>
            <li><a class="glyphicon glyphicon-envelope" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=admin%40tlip%2ecn">&nbsp;入驻&nbsp;[审核]</a></li>
            <li class="dropdown">
              <a class="glyphicon glyphicon-align-left" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;更多 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="javascript:void(0)">NULL</a></li>
                <li><a href="javascript:void(0)">NULL</a></li>
                <li><a href="javascript:void(0)">NULL</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">NULL</li>
                <li><a href="javascript:void(0)">NULL</a></li>
                <li><a href="javascript:void(0)">NULL</a></li>
              </ul>
            </li>
            <li>
              <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="未完善...">
                <button type="submit" class="btn btn-default">搜索</button>
              </form>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
                <?php if($_SESSION['manager_info']== false): ?><li role="presentation"><a  href="#myModal" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-edit"></span>&nbsp;注册</a></li>
                    <li role="presentation"><a class="glyphicon glyphicon-user" href=<?php echo U("Admin/login/index");?>>&nbsp;登录</a></li>


                <?php else: ?>
                    <li role="presentation"><a class="glyphicon glyphicon-user" href=<?php echo U("Admin/index/index");?>>&nbsp;后台管理</a></li>
                    <li role="presentation"><a href="javacript:void(0);" target="_top" class="h"><?php echo ($_SESSION['manager_info']['nickname']); ?></a></li><?php endif; ?>
                <span class="sr-only">(current)</span>
            <li role="presentation"><a class="glyphicon glyphicon-off" href=<?php echo U("Admin/login/logout");?>>&nbsp;退出</a></li>
          </ul>

            </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav><!-- navbar -->
<!--注册-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">新用户注册</h4>
            </div>
            <div class="modal-body">
                <form action=<?php echo U("index/register");?> method="post">
                    <div class="form-group">
                        <label for="">用户名</label>
                        <input type="text" name="username" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="">密码</label>
                        <input type="password" name="old_password" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="">确认密码</label>
                        <input type="password" name="re_password" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="">昵称</label>
                        <input type="text" name="nickname" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="">邮箱</label>
                        <input type="text" name="email" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="">验证码</label>
                        <div class="input-group">
                            <!--<span class="input-group-addon input-group-lg" >验证码：</span>-->
                            <input type="text" class="form-control" placeholder="Code" name="code" />
                            <span class="input-group-addon input-group-lg" >
                                <img style="width: 100px;height:20px" onclick="this.src='<?php echo U('index/verify');?>?'+Math.random();" src="<?php echo U('index/verify');?>"/>
                            </span>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo ($_SESSION['manager_info']['id']); ?>"/>


                    <div class="form-group modal-footer">
                        <input type="submit" value="确认提交" class="btn btn-success">
                        <input type="reset" value="重置内容" class="btn btn-danger">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">右侧栏</button>
          </p>
<!-- 页面关键词 keywords -->
<meta name="keywords" content="斑马缘,博客园,斑马缘博客园,博客园平台,miniblog,miniblog.top">
<!-- 页面描述内容 description -->
<meta name="description" content="‘斑马缘’是一个迷你博客园(平台)，由项目负责人@油果,和他的团队们“zebra”开发小组共同完成以及维护的开源项目。他们的服务宗旨是：提供免费的入驻博客园服务，享受免费的博文发布以及博文管理服务！‘斑马缘’欢迎您的入驻！">
<!-- 新模块往这里写 -->
<!-- 博文 情景模块 begin-->
<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="panel" style="background-color:#f6f6f6;">
      <div class="panel-heading">
      <span class="panel-title">Title：<a href="<?php echo U('Home/Index/detail');?>?id=<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a><span class="pull-right">Create：<?php echo ($v["create_time"]); ?> &#9674; 访问量：<?php echo ($v["hits"]); ?></span></span>
      </div>
      <div class="panel-body clearfix"><!-- clearfix清除浮动、pull-left左浮动、pull-right右浮动 -->
      <p class="lead">
        <small>UpDate：<?php echo ($v["update_time"]); ?></small><br>
        <small>Author: <?php echo ($v["nickname"]); ?>&emsp;点赞：<?php echo ($v["zan"]); ?> &emsp;<del>评论：0 </del></small><span class="pull-right"><a href="<?php echo U('Home/Index/detail');?>?id=<?php echo ($v["id"]); ?>">查看全文</a></span>
        <hr><?php echo ($v["content"]); ?>
      </p>
      </div>
  </div><?php endforeach; endif; else: echo "" ;endif; ?>

</article><!-- end-markdown-body -->
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
// 和风天气API

function tq_api(){

  var city=$('.tq_city').val();

  //发送ajax请求
// console.log(city);

  $.ajax({

      'url':'/home/index/api_tq',

      'type':'get',

      'data':'city=' + city,

      'dataType':'json',

      'success':function(response){

          // console.log(response);

          //显示到页面

          $('.api_tq_data').html(response);

      },

  }); 

}

// 绑定HTML加载完成事件
$(document).ready(function(){
  tq_api(); // 查一次天气
  });  
// 控制富文本内容中较大图片的响应式支持效果
  $("div p img").addClass("img-responsive");
  // $(".zccode").removeClass("img-responsive");
  /**
   * 友情链接访问量统计
   * @author TabKey9 <Admin@tlip.cn>
   * @date        2018-09-05
   * @param string id 链接ID
   * @return json 执行结果
   */
  function clickLink(id){
    $.ajax({

        'url':'/home/index/clickLink',

        'type':'get',

        'data':'id=' + id,

        'dataType':'json',

        'success':function(response){

             console.log(response);
        },

    }); 
  }
</script>

<!--右侧菜单栏 begin-->
            <!-- this is 右侧响应式支持 -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">

<!-- 右边侧边栏第1个展区 -->
    <?php if($_SESSION['manager_info']['nickname']== false): ?><div class="thumbnail" style="background-color:#f6f6f6;">
        <div class="caption">
          <label class="control-label">最新回复列表：</label>
          <p>
            <?php if(is_array($top10)): $i = 0; $__LIST__ = $top10;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Home/Index/detail');?>?id=<?php echo ($t["id"]); ?>"><?php echo ($t["title"]); ?></a><br><?php endforeach; endif; else: echo "" ;endif; ?>
          </p>
        </div>
      </div>
    <?php else: ?>
      <div class="thumbnail" style="background-color:#f6f6f6;">
        <img width="100%" src="/Static/abc.gif" alt="bg:NULL">
        <div class="caption">
          <!-- User Logo Css figure begin -->
          <figure style="width: 100px;height: 100px;margin-left: 25%;margin-top: -25%;">
          <img class="img-circle img-thumbnail" src="/Static/userlogo.png" alt="userlogo">
          </figure>
          <h3>博主：<?php echo ($_SESSION['manager_info']['nickname']); ?></h3>
          <p><label class="control-label">文章：</label>
            <a href="javascript:void(0)" class="btn btn-default" role="button">NULL</a>
            <a href="javascript:void(0)" class="btn btn-default" role="button">NULL</a>
            <a href="javascript:void(0)" class="btn btn-default" role="button">NULL</a>
            <a href="javascript:void(0)" class="btn btn-default" role="button">NULL</a>
            <a href="javascript:void(0)" class="btn btn-default" role="button">......</a>
          </p>
        </div>
      </div><?php endif; ?>

<!-- 这里展示天气 -->
    <div class="thumbnail" style="background-color:#f6f6f6;">
      <img src="/Static/tianqi.png" alt="和风天气">
      <div class="caption">
        <label class="control-label">由“<a href="https://www.heweather.com/price">和风天气</a>”提供服务</label>
          <div class="input-group">
            <input placeholder="北京" type="text" class="form-control tq_city">
            <span class="input-group-btn">
              <button class="btn btn-success" onclick="tq_api()" type="button">查询</button>
            </span>
          </div>
          <div class="lead text-info api_tq_data">累计查询次数：<?php echo ($count); ?></div>
      </div>
    </div>

<!-- 友情链接 -->
    <div class="thumbnail" style="background-color:#f6f6f6;">
      <img src="/Static/yqlj.jpg" alt="友情链接">
      <div class="caption">
        <label class="control-label"><a target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=admin%40tlip%2ecn">审核</a>&#8629;</label>
        <br>链接 | 访问量 | 来访次数
          <?php if(is_array($links)): $i = 0; $__LIST__ = $links;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><p><a href="<?php echo ($v["url"]); ?>" onclick="clickLink(<?php echo ($v["id"]); ?>);"><?php echo ($v["explain"]); ?></a>&emsp;<?php echo ($v["click"]); ?>&emsp;<?php echo ($v["returl"]); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>
    </div>

<!-- APP -->
    <div class="thumbnail" style="background-color:#f6f6f6;">
      <label class="control-label text-center">斑马缘安卓APP</label>
      <img src="/Static/app2.png" alt="app2.png">
      <span><a href="http://downloadpkg.apicloud.com/app/download?path=http://7zsxnk.com1.z0.glb.clouddn.com/9ac4fcc2c2e8fd1622fe1a1626a56723_d">下载：1.1M</a></span>
    </div>
<!-- end 右1 -->
    <!--右侧菜单栏 end-->


        </div><!--/.sidebar-offcanvas-->
      </div><!--/row row-offcanvas-->

<!-- 底部 begin -->

<footer class="footer" style="clear: both">
  <p><?php echo ($times); ?>&emsp;<hr><a href='https://github.com/lvlinjian/Mini-Blog'>“斑马缘”MiniBlog项目 - 开放源码</a><br>Author: admin@tlip.cn&emsp;<a href=http://www.miitbeian.gov.cn/ target=_blank>京ICP备18012961号-1</a>&emsp;</p>
</footer>
    </div><!--  end container -->
</body>
</html>
<!-- 百度统计 -->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?b0230bfc08dee11f7f5ce9a9e03ed502";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>