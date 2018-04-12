<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends Controller{
	//发送注册验证码
	public function sendmsg(){
		//接收参数
		$phone = I('post.phone');
		//处理数据(发送短信)
		
		//判断发送频率(扩展,可以限制IP)
		$last_time = session('register_time_'.$phone)?:0;
		$time = time();
		if($time - $last_time < 60){
			//发送太频繁
			$return = [
				'code' =>10003,
				'msg' =>'发送太频繁'
			];
			$this->ajaxReturn($return);
		}
		// 准备请求地址 请求参数
		$url = "https://way.jd.com/chuangxin/dxjk";
		$appkey = "0f52b04b3430922bdf26be4086d9b97a";
		$code = mt_rand(1000,9999);
		$content = "【成都创信信息】验证码为：{$code},欢迎注册平台！";
		$request_url = $url . "?appkey={$appkey}&mobile={$phone}&content={$content}";
		//调用curl_request函数发送请求
		$res = curl_request($request_url,false,array(),true);
		//dump($res);
		//返回数据
		if(!$res){
			//请求失败
			$return =[
				'code' =>10001,
				'msg' =>"发送失败,服务器异常"
			];
			$this ->ajaxReturn($return);
			//解析数据
			$arr = json_decode($res,true);
			//发送失败
			$return = [
				'code' =>10002,
				'msg' =>"发送失败"
			];
			$this->ajaxReturn($return);
		}
		//发送成功
		//将验证码保存到session中,用于后续的校验
		session('register_code_'.$phone,$code);
		//记录发送时间
		session('register_time_'.$phone,time());
		$return = [
			'code' =>10000,
			'msg' =>"发送成功",
			'data' =>$code
			
		];
		$this->ajaxReturn($return);
	}

	//qq登录回调地址
	public function qqcallback(){
		//数据处理。。。
		require_once("./Application/Tools/qq/API/qqConnectAPI.php");
		$qc = new \QC();
		//获取access_token，请求过程中的临时授权码
		$access_token = $qc->qq_callback();
		//获取openid, qq账号在一个应用的唯一身份标识
		$openid = $qc->get_openid();
		//重新携带参数实例化qc类
		$qc = new \QC($access_token, $openid);
		//获取用户信息
		$info = $qc -> get_user_info();
		// dump($info);die;

		//获取昵称，用于添加到用户表
		$nickname = $info['nickname'];
		//自动注册
		$user = D('User') -> where(['openid' => $openid]) -> find();
		if(!$user){
			//用户不存在，则自动注册
			$row = [
				'username' => $nickname,
				'openid' => $openid,
				'create_time' => time()
			];
			$res = D('User') -> add($row);
			if(!$res){
				//添加成功
				$this -> error('登录失败');
			}
		}else{
			//用户已存在，则更新昵称等信息
			$user['username'] = $nickname;
			D('User') -> save($user);
		}
		//重新查询用户信息
		$user = D('User') -> where(['openid' => $openid]) -> find();
		//自动登录（设置登录标识）
		session('user_info', $user);
		//最后跳转到首页
		$this -> redirect('Home/Index/index');

		//如果是打开的新窗口，跳转的代码如下：
		// echo "<script>window.opener.location.href='/';window.close();</script>";
	}



	
}
