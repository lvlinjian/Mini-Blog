<?php 
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{
	public function __construct(){
		// 调用父类构造方法
		parent::__construct();
		// 登录判断
		if(!session('?manager_info')){
			// 没有登录跳转到登录页
			// $this ->redirect('Admin/Login/login');//把redirect()改用success()跳转方式比较友好
			layout(false);// 临时关闭全局布局
			$this->success('未登录！页面跳转中...',U('Admin/Login/index'), 3 );
			die;// 如果不die掉的话，会显示多余的信息
		}
		$this->getauth();

		$this -> checkauth();
	}
	public function getauth(){
		if(session('?top') && session('?second')){

		}
		$role_id = session('manager_info.role_id');
		//根据权限表 查询拥有的权限
		if($role_id == 1){
			$data =[];
			//查询所有的权限
			$top = D('Auth') -> where("pid = 0 and is_nav = 1")->select();
			$second = D('Auth') -> where("pid > 0 and is_nav = 1") -> select();
		}else{
			$role = D('Role') -> where(['role_id' => $role_id]) -> find();
			$role_auth_ids = $role['role_auth_ids'];
			//查询所有的权限
			$top = D('Auth') -> where("id in ({$role_auth_ids}) and pid = 0 and is_nav = 1") ->select();
			$second = D('Auth') -> where("id in ({$role_auth_ids}) and pid > 0 and is_nav = 1") ->select();
		}

		
		session('top',$top);
		session('second',$second);
		// dump(session());die;
	}
	//权限检测
	public function checkauth(){
		//从session获取登录管理员的role_id
		$role_id = session('manager_info.role_id');
		if($role_id == 1){
			return true;
		}
		//获取当前页面权限（控制器名称、方法名称）
		$c = CONTROLLER_NAME;
		$a = ACTION_NAME;
		//判断当前页面如果是特殊的，比如首页，不需要检测
		$ac = $c . '-' .$a;
		// dump($ac);die;
		if($ac == "Index-index"){
			return true;
		}
		//根据role_id 获取当前管理员拥有的权限
		$role = D('Role') -> where(['role_id' =>$role_id]) ->find();
		// dump($role);die;
		//判断管理员是否拥有当前页面的权限
		$role_auth_ac = explode(',',$role['role_auth_ac']);
		// dump($role_auth_ac);die;
		if(!in_array($ac,$role_auth_ac)){
			$this -> error('没有此页面的权限', U('Admin/Index/index'));
		}
		return true;
	}
}

?>