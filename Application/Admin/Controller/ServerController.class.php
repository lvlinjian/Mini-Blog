<?php
namespace Admin\Controller;
use Think\Controller;
class ServerController extends CommonController{
	public function index(){
		$this->getauth();
		layout(false);
		include_once 'Public/Admin/ServerInfo.php';		
		$this ->display();

	}
	// 服务器环境信息探针
	public function info(){
		$this->getauth();
		layout(false);
		include_once 'Public/Admin/ServerInfo.php';
		$this ->display();
	}

}