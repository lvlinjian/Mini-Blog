<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
	// 后台登录页
	public function index(){

		//一个方法处理两个逻辑
		if(IS_POST){
/*			//post请求  表单提交
			//接收数据
			$username = I('post.username');
			$password = I('post.password');
			$code = I('post.code');
			//参数检测
			if(empty($username) || empty($password) || empty($code)){
				$this->error('参数不全');
			}
			//验证码校验
			//实例化Verify类
			$verify = new \Think\Verify();
			//调用check方法进行校验
			$check = $verify->check($code);
			if(!$check){
				//验证码错误
				$this->error('验证码错误');
			}
			//根据用户名查询tpshop_manager表
			$info = D('Manager')->where(['username'=>$username])->find();
			//如果查询到用户,则对此密码(将明文加密)
			if($info && $info['password'] == md5_password($password)){
				//用户名存在且密码一致,登录成功
				//设置登录标识
				session('manager_info',$info);
				// if(!session('manager_info.create_time')){
				// 	$create_time = date('Y/m/h H:i:s');
				// dump($create_time);die;
				// $id = session('manager_info.id');
				// $data = array(
				// 		'id' =>$id,
				// 		'create_time' => $create_time
				// 	);
				// $res = D('Manager')->save($data);
				// }
				$this->success('登录成功',U('Admin/Index/index'));
			}else{
				//登录失败
				$this->error('用户名或密码错误');
			}*/
		}else{
			//页面展示
			//①如果已经登录,直接跳转到后台首页
			//②如果已经登录,自动退出重新打开登录页面
			if(session('?manager_info')){
				session(null);
			}
			//临时关闭全局布局
			layout(false);
		//调用模板
		$this->display();

		}
	}
		
	public function logout(){
		$last_login_time = date('H:i:s');
		// dump($last_login_time);die;
		$id = session('manager_info.id');
		$data = array(
				'id' =>$id,
				'last_login_time' => $last_login_time
			);
		$res = D('Manager')->save($data);
		// dump($res);die;
		if(!$res){
			$this->error('服务器繁忙问题');
		}
		session(null);
        $this->success('退出成功',U('Home/Index/index'), 2 );

	}

	public function captcha(){
		//实例化验证码类Verify类
		$config = array(
			'length' =>2,	//验证码位数
			'useCurve' => false,	//是否画混淆曲线
			'useNoise' => false,	//是否添加杂点
		);
		$verify = new \Think\Verify($config);
		//调用entry方法生成并输出验证码图片
		$verify -> entry();
	}

	//ajax登录方法
	public function ajaxlogin(){
		// echo "string";die;
		//post请求  表单提交
		//接收参数
		$username = I('post.username');
		$password = I('post.password');
		$code = I('post.code');
		//参数检测
		if(empty($username) || empty($password) || empty($code)){
			$return = [
				'code' => 10001,
				'msg' =>'参数不全',
			];
			$this -> ajaxReturn($return);
		}


		// 验证码校验
		// 实例化Verify
		$verify = new \Think\Verify();
		// 调用check方法进行校验
		$check = $verify ->check($code);
		if(!$check){
			// 验证码错误
			$return =[
				'code' => 10002,
				'msg' =>'验证码错误'
			];
			$this ->ajaxReturn($return);
		}
		
		// 根据用户名查询tpshop_manager表
		$info = D('Manager') ->where(['username'=>$username])->find();
		// 如果查询到用户,则比对密码(将明文加密)
		if($info && $info['password'] ==md5_password($password)){
			// 用户名存在且密码一致,登录成功
			// 设置登录标识
			session('manager_info',$info);
			$return = [
				'code' =>10000,
				'msg' =>'success'
			];
			$this ->ajaxReturn($return);
		}else{
			// 登录失败
			$return =[
				'code' =>10003,
				'msg' =>'用户名或密码错误'
			];
			$this ->ajaxReturn($return);
		}
	}


}