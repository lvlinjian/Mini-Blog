<?php
namespace Admin\Controller;
use Think\Controller;
class ManagerController extends CommonController{
	public function index(){
		$model = D('Manager');
		$content = I('get.content');
		// dump($content);die;
		$map['username|nickname'] = array('like','%'.$content.'%');
		// $map2['email'] = array('like','%'.$content.'%');
		// $map3['nickname'] = array('like','%'.$content.'%');
		// $map['id'] = array('gt',1);
		// 查询总记录数
		$total = $model ->where($map)->count();
		
		// dump($total);die;
		$pagesize = 4;
		//实例化分页类
		$page = new \Think\Page($total,$pagesize);
		//定制分页栏显示
		$page -> setConfig('prev','上一页');
		$page -> setConfig('next','下一页');
		$page -> setConfig('first','首页');
		$page -> setConfig('last','尾页');
		$page -> setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$page -> rollPage = 6;
		$page -> lastSuffix = false;
		// 调用show方法获取分页栏代码
		$page_html = $page -> show();
		$this -> assign('page_html', $page_html);
		// if(!$page->firstRow != 1){
		// 	$page->firstRow = 1;
		// }
		$data =$model->field('id,username,email,nickname,last_login_time,status')->where($map)->limit($page->firstRow, $page->listRows)->select(); 

		$this->assign('data',$data);
		$this->display();
	}
	public function add(){
		if(IS_POST){
			$data = I('post.');
			// dump($data);die;
			if(empty($data['username'])){
				$this -> error('必填项不能为空');
			}
			$res = D('Manager')->add($data);
			// dump($res);die;
			if($res !== false){
				$this->success('添加成功！',U('Admin/Manager/index'));
				exit;
			}else{
				$this->error('请重新填写数据，进行提交');
			}
		}else{
			$data = D('Role')->select();
			$this->assign('data',$data);
			$this->display();
		}
	}
	public function edit(){
		if(IS_POST){
			$data = I('post.');
			if(empty($data['username'])){
				$this -> error('必填项不能为空');
			}
			// dump($data);die;
			$data['password'] = md5_password($data['password']);
			// dump($data);die;
			$res = M('Manager') -> save($data);
			// dump($res);die;
			if($res !== false){
				$this -> success('操作成功', U('Admin/Manager/index'));
			}else{
				$this -> error('操作失败');
			}
		}
		else{
			$id = I('get.id',0,'intval');
			if($id <= 0){
				$this -> error('参数错误');
			}
			//$oldinfo = D('Manager')->find($id);
			$oldinfo = D('Manager')->where(['id' => $id])->find();
			// dump($data);die;
			$data = D('Role')->select();
			$this->assign('data',$data);
			$this->assign('oldinfo',$oldinfo);			
			$this->display();
		}
	}
	public function del(){
		$id = I('get.id');
		// dump($id);die;
		$model = M('Manager');
		$res = $model->delete($id);
		// dump($res);die;
		if($res===1){
			//删除成功
			$this -> success('删除成功',U('Admin/Manager/index'));
			exit;
		}else{
			$this->error('删除失败');
		}
		$this->display();
	}
}
