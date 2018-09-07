<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 各种与链接相关的控制器集合，比如友情链接
 */
class LinksController extends CommonController
{
	/**
	 * 拒绝非POST请求
	 */
	public function notPost(){
		if (!IS_POST) {
			die;
		}
	}
	/**
	 * 新增友情链接
	 * @date        2018-09-04
	 * @author TabKey9 <Admin@tlip.cn>
	 * @param  array $post 数据表单
	 * @return array $msg 执行结果
	 */
	public function addLink(){
		$this->notPost();//拒绝非post请求
		$post = I('post.');
		// dump($post);die;
		$data = D('Link');
		$post['adddate'] = $post['update'] = time(); // 首次添加，时间戳赋值
		$res = $data->addData($post);
		if ($res < 0 || $res == false) {
			$this->error('失败');
		}else{
			$this->success('成功',U('Admin/Links/index'));
		}
	}
	/**
	 * 修改保存友情链接
	 * @date        2018-09-04
	 * @author TabKey9 <Admin@tlip.cn>
	 * @param  array $post 数据表单
	 * @return array $msg 受影响行数
	 */
	public function saveLink(){
		$this->notPost();//拒绝非post请求
		$post = I('post.');
		$post['update'] = time();
		$res = D('Link')->saveData($post);
		if ($res < 0 || $res == false) {
			$this->error('失败');
		}else{
			$this->success('成功',U('Admin/Links/index'));
		}
		// dump($msg);
	}
	/**
	 * 查看友情链接 - 列表
	 * @date        2018-09-04
	 * @author TabKey9 <Admin@tlip.cn>
	 * @param  array $param 查询条件
	 * @return array $msg 执行结果
	 */
	public function getLinks(){
		$param['where'] = 'deldate=0';
		$res = D('Link')->getDatas($param);
		if ($res == false) {
			$msg['code'] = false;
			$msg['msg'] = error;
			$msg['data'] = $res;
		}else{
			$msg['code'] = true;
			$msg['msg'] = success;
			$msg['data'] = $res;
		}
		// dump($msg);
		return $msg;
	}
	/**
	 * 查看友情链接 - 1条
	 * @date        2018-09-04
	 * @author TabKey9 <Admin@tlip.cn>
	 * @param  array $param 查询条件
	 * @return array $msg 执行结果
	 */
	public function getLink($id=''){
		if (empty($id)) {
			return;
		}
		$param['where'] = 'id='.$id.' and deldate=0';
		$res = D('Link')->getOneData($param);
		if ($res < 0 || $res == false) {
			$msg['code'] = false;
			$msg['msg'] = error;
			$msg['data'] = $res;
		}else{
			$msg['code'] = true;
			$msg['msg'] = success;
			$msg['data'] = $res;
		}
		return $msg;
	}
	/**
	 * 删除友情链接 - 1条 - 假删
	 * @date        2018-09-04
	 * @author TabKey9 <Admin@tlip.cn>
	 * @param  array $param 指定ID，以及记录删除的时间戳
	 * @return array $msg 执行结果
	 */
	public function delLink(){
		$get = I('get.');
		$param['id'] = $get['id'];
		$param['deldate'] = time();
		$res = D('Link')->falseDelOneData($param);
		// dump($res);
		if ($res < 0 || $res == false) {
			$this->error('失败');
		}else{
			$this->success('成功',U('Admin/Links/index'));
		}
	}
	/**
	 * 删除友情链接 - 所有 - 假删
	 * @date        2018-09-04
	 * @author TabKey9 <Admin@tlip.cn>
	 * @param  array $param 记录删除的时间戳
	 * @return array $msg 受影响行数
	 */
	public function delLinks(){
		$param['deldate'] = time();
		$res = D('Link')->falseDelDatas($param);
		// dump($res);
		if ($res < 0 || $res == false) {
			$this->error('失败');
		}else{
			$this->success('成功',U('Admin/Links/index'));
		}
	}
	/**
	 * 链接管理页面
	 * @author TabKey9 <Admin@tlip.cn>
	 * @date        2018-09-04
	 * @return void
	 */
	public function index(){
		$data = $this->getLinks()['data'];
		foreach ($data as &$v) {
			$v['url'] = cutstr($v['url'],20);// 摘要一小段内容
			$v['explain'] = cutstr($v['explain'],20);
		}
		// dump($data);
		$this->assign('data',$data);
		$this->display();
	}
	// 编辑时，查询一条
	public function edit(){
		$id = I('get.id');
		$this->assign('data',$this->getLink($id)['data']);
		$this->display();
	}
}