<?php 
namespace Admin\Controller;
use Think\Controller;
class AuthController extends CommonController{
	public function index(){
		$data = D('Auth')->select();
		$data = getTree($data);
		$this->assign('data',$data);
		$this->display();
	}
	public function add(){
		if(IS_POST){
			$data = I('post.');
			// dump($data);die;
			$res = D('Auth')->add($data);
			if($res){
				$this->success('添加成功',U('Admin/Auth/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			// 首页显示顶级权限
			$top_all = D('Auth')->where('pid = 0')->select();
			$this->assign('top_all',$top_all);
			$this->display();
		}
	}
	public function edit(){
		if(IS_POST){
			$data = I('post.');
			// dump($data);die;
			$res = D('Auth')->where(['id' =>$data['id']])->save($data);
			if($res){
				$this -> success('修改成功',U('Admin/Auth/index'));
			}else{
				$this -> error('修改失败');
			}
		}else{
			$id = I('get.id');
			// dump($id);die;
			$data = D('Auth')->find($id);
			// dump($data);die;
			$top_all = D('Auth')->where('pid = 0')->select();
			// dump($top_all);die;
			$this->assign('top_all',$top_all);
			$this->assign('data',$data);
			$this->display();
		}
	}
	public function del(){
		$id = I('get.id');
		$res = D('Auth')->delete($id);
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








 ?>