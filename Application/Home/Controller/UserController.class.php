<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller
{
    public function _empty($name)
    {
        $this->display('index/index');
    }

    //注册
    public function register()
    {
		//一个方法两个逻辑
		if(IS_POST){
			//post请求
			//接收数据
			$data= I('post.');
			//dump($data);
			//手机号注册
			if($data['phone']){
				//短信验证码校验
				$code = session('register_code_' . $data['phone']);
				if(empty($data['code']) || $data['code'] !=$code){
					//短信验证码错误
					$this->error('短信验证码错误');
				}
				//验证码有效期
				$send_time = session('register_time_'.$data['phone']);
				$time = time();
				if($time - $send_time > 300){
					//过期
					$this->error('验证码已失效');
				}
				//验证码成功后失败
				session('register_code_' . $data['phone'],null);
				session('register_time_' . $data['phone'],null);
			}
			//邮箱注册
			if($data['email']){
				//生成验证码
				$code = mt_rand(1000,9999);
				$data['email_code'] = $code;
			}
			//参数检测 自动验证
			$model = D('Manager');
			if(!$model->create($data)){
				//验证失败
				$error = $model->getError();
				$this ->error($error);
			}
			//进行注册 添加数据到用户表
			$res = $model->add();
			if($res){
				//注册成功
				if($data['email']){
					//发送激活邮件
					$subject = "斑马缘播客注册激活邮件";
					$body = "恭喜注册成功，请点击一下链接进行激活：<br><a href='http://47.94.9.214/Home/User/jihuo/id/{$res}/code/{$code}'>点我激活</a><br>如果页面无法自动跳转，请复制链接重新在浏览器打开";
					//调用封装的sendmail函数发送邮件
					sendmail($data['email'], $subject, $body);
				}
				$this->success('注册成功',U('Home/User/login'));
			}else{
//				注册失败
				$this->error('注册失败');
			}
		}else{
		//临时关闭布局
		layout(false);
		$this->display();

		}
	}
	//登录
	public function login(){
		//一个方法两个业务逻辑
		if(IS_POST){
			//表单提交
			//接收数据
			$data = I('post.');
//            echo "<pre>";
//            print_r($data);
//            exit;
			//参数检测
			if(empty($data['manager']) || empty($data['password'])){
				//参数错误
				$this->error('参数错误');
			}
			$user = D('Manager')->where([
				'Manager' => $data['Manager'],
				'password' => md5_password($data['password'])
				])->find();
			if(!$user){
				//根据email字段查询
				$user = D('Manager')->where([
					'email' => $data['Manager'],
					'password' =>md5_password($data['password'])
				])->find();
			}
			if(!$user){
				//根据phone字段查询
				$user = D('User')->where([
					'phone' => $data['username'],
					'password' =>md5_password($data['password'])
				])->find();
			}
			//判断用户知否查询到
			if(!$user){
				//用户名不存在或者密码错误
				$this->error('用户名不存在或者密码错误');
			}else{
				//判断是否激活
				if($user['is_check'] != 1){
					$this -> error('账号未激活');
				}
				//登录成功
				//设置session
				session('user_info',$user);
				//调用Cart模型的方法,将cookie中的购物车数据迁移到数据表
				D('Cart') ->cookieTodb();
				//从session读取back_url 如果没有则跳转到首页
				$back_url = session('back_url');
				$back_url ? $back_url : U('Home/Index/index');
				$this -> success('登陆成功',U('Home/Index/index'));
				}
		}else{
			layout(false);
			//调用模板
			$this->display();
		}
	}
	//退出
	public function logout(){
		//情况session
		session(null);
		$this->redirect('Admin/Index/login');
	}
	//激活账号的方法
	public function jihuo(){
		//参数 用户id参数  验证码code参数
		$id = I('get.id');
		$code = I('get.code');
		//检测用户是否存在
		$user = D('User') -> where(['id' => $id]) -> find();
		if(!$user){
			$this -> error('激活失败');
		}
		//检测验证码是否正确
		if($code != $user['email_code']){
			$this -> error('激活失败');
		}
		//修改用户的激活状态字段
		$user['is_check'] = 1;
		$res = D('User') -> save($user);
		if($res === false){
			$this -> error('激活失败');
		}
		$this -> success('激活成功', U('Home/User/login'));
	}
}
