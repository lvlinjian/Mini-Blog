<?php 
namespace Admin\Controller;
use Think\Controller;

class RoleController extends CommonController{
	public function index(){
		$model = D('Role');
		$data = $model -> select();
		//查询总记录数
		$total = $model -> count();
		$pagesize = 4;
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
		$this -> assign('data',$data);
		$this -> display();
	}
	public function add(){
		if(IS_POST){
			$data = I('post.');
			$role_name = $data['role_name'];
			$role_auth_ids = $data['role_auth_ids'];
			// dump($role_auth_ids);die;
			if(empty($data['role_name'])){
				$this -> error('必填项不能为空');
			}else{
				$role_auth_ids = implode(',',$role_auth_ids);
				// dump($role_auth_ids);die;
				$res=D('Auth') -> where("id in ($role_auth_ids) and pid !=0") -> select();
				// dump($res);die;
				$role_auth_ac = '';
				foreach ($res as $value) {
					$role_auth_ac .= $value['auth_c'] . '-' . $value['auth_a'] . ',';
				}
				$role_auth_ac = trim($role_auth_ac,',');
				// dump($role_auth_ac);die;
				$data = array(
					'role_name' => $role_name,
					'role_auth_ids' => $role_auth_ids,
					'role_auth_ac'  => $role_auth_ac
					);
				// dump($data);die;
				$res = D('Role') -> add($data);
				if($res){
					$this -> success('添加成功',U('Admin/Role/index'));
				}else{
					$this -> error('添加失败');
				}
			}
		}else{
			//查询顶级权限
			$top = D('Auth')->where("pid = 0")->select();
			$this->assign('top',$top);
			//查询二级权限
			$second = D('Auth')->where("pid > 0")->select();
			$this->assign('second',$second);
			$this->display();
		}
	}
	//为角色分配权限
	public function setauth(){
		if(IS_POST){
			$data = I('post.');
			// dump($data);die;
			$role_name = $data['role_name'];
			if(empty($data['role_name'])){
				$this -> error('必填项不能为空');
			}
			$role_auth_ids = implode(',',$data['id']);
			$res = D('Auth') -> where("id in ({$role_auth_ids}) and pid > 0") -> select();
			// dump($res);die;
			$role_auth_ac = '';
			foreach($res as $k=>$v){
				$role_auth_ac .=$v['auth_c']. '-' . $v['auth_a'] . ',';
			}
			$role_auth_ac = trim($role_auth_ac,',');
			// dump($role_auth_ac);die;
			$data = array(
					'role_id' => $data['role_id'],
					'role_name' => $data['role_name'],
					'role_auth_ids' => $role_auth_ids,
					'role_auth_ac'  => $role_auth_ac
				);
			// dump($data);
			$res = D('Role') -> save($data);
			// dump($res);die;
			if($res){
					$this -> success('修改成功',U('Admin/Role/index'));
				}else{
					$this -> error('修改失败');
				}
		}else{
			$id = I('get.id');
			$role = D('Role')->where(['role_id' => $id])->find();
			$this->assign('role',$role);
			//查询顶级权限
			$top = D('Auth')->where("pid = 0")->select();
			$this->assign('top',$top);
			//查询二级权限
			$second = D('Auth')->where("pid > 0")->select();
			$this->assign('second',$second);
			$this->display();
		}
	}
	public function del(){
		$id = I('get.id');
		// dump($id);die;
		$res = M('Role') -> delete($id);
		if($res===1){
			//删除成功
			$this -> success('删除成功',U('Admin/Role/index'));
			exit;
		}else{
			$this -> error ('删除失败');
		}
		$this->display();
	}
}







 ?>