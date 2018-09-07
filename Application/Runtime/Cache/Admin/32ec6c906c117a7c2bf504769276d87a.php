<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>油果|Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/offcanvas.css">
    <script type="text/javascript" src="/Public/bootstrap/js/jq.js"></script>
    <script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/bootstrap/js/offcanvas.js"></script>
    </head>
<body>
  <div class="jumbotron">
    <h1>Hello, MiniBlog!</h1>
    <div class="msg">请先登录</div>
    <form class="form-inline">
      <div class="form-group">
        <img class="pull-right" id="code" src="/Admin/Login/captcha" onclick="this.src='/Admin/Login/captcha/_/' + Math.random();">
      </div><br>
      <div class="form-group has-success has-feedback">
        <div class="input-group">
          <span class="input-group-addon">验证</span>
          <input type="text" id='verify' name="code"  class="form-control" placeholder="这里输入验证码">
        </div>
      </div><br>
      <div class="form-group has-success has-feedback">
        <div class="input-group">
          <span class="input-group-addon">用户</span>
          <input type="text" class="form-control" placeholder="这里输入用户名"  id='username' name="username">
        </div>
      </div><br>
      <div class="form-group has-success has-feedback">
        <div class="input-group">
          <span class="input-group-addon">密码</span>
          <input type="password" id="password" name="password" class="form-control" placeholder="这里输入密码">
          <span class="input-group-btn">
            <button class="btn btn-success" type="button">登录</button>
          </span>
        </div>
      </div><br>
    </form> 
    <p><a href="javascript:void(0)" class="btn btn-default" role="button">忘记密码</a> <a href="<?php echo U('Home/Index/register');?>" class="btn btn-default" role="button">免费注册</a></p>
    <p>
      其他登录方式：NULL
    </p>
  </div>
  <script type="text/javascript">
    $(function(){
      // 回车
      $('#password').keyup(function(event){
        if(event.keyCode ==13){
          $('.btn-success').trigger('click');
        }
      });
      // 点击
      $('.btn-success').on('click',function(){
          if($('#verify').val() == ''){
              $('.msg').html('验证码不能为空');
              return;
          }
          if($('#username').val() == ''){
              $('.msg').html('登录名不能为空');
              return;
          }
          if($('#password').val() == ''){
              $('.msg').html('密码不能为空');
              return;
          }
          //准备请求参数
          var data = {
              'username': $('#username').val(),
              'password': $('#password').val(),
              'code': $('#verify').val(),
          };
          //发送ajax请求
          $.ajax({
              'url':'/Admin/Login/ajaxlogin',
              'type':'post',
              'data':data,
              'dataType':'json',
              'success':function(response){
                  if(response.code != 10000){
                      //刷新验证码
                      $('#code').attr('src', '/Admin/Login/captcha/_/' + Math.random());
                  }else{
                      //登录成功 跳转到后台首页
                      location.href = "/Admin/Index/index.html";
                  }
              },
          });
      });
    });
</script>
</body>
</html>