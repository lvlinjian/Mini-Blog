<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 各种与链接相关的控制器集合，比如友情链接
 */
class LinksController extends Controller
{
	public function addLink(){
		dump($_SESSION['manager_info']);
		echo $user_id;
		$data = D('Link');
		$param['adddate'] = $param['update'] = time(); // 首次添加，时间戳赋值
		echo $data->addlink();
        // $this ->assign('times',$times);
        // 展示数据
		// $this ->display('index.html');
	}
}