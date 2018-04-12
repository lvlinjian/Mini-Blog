<?php 
namespace Admin\Controller;
use Think\Controller;
class TypeController extends CommonController{
	public function add(){
		if (IS_POST) {
			$data=I('post.');
			// dump($data);die;
			if ($data['cate_name'] && $data['cate_desc']) {
				$model=D('cate');
				$res=$model->add($data);
				if ($res) {
					$this->success('新增成功',U('Admin/Type/index'));
				}else{
					$this->error('新增失败！');
				}
			}else{
				$this->error('参数不足！');
			}
			
		}else{
			$this ->display();
		}
	}
	public function lists(){
		$model=D('cate');
		// $data =$model ->select();
		$content = I('post.content');
		$this->assign('content',$content);
		$map['cate_name'] = array('like','%'.$content.'%');
		$total =$model ->where($map)->count();
		$pagesize = 2;
		$page = new \Think\Page($total,$pagesize);
		// 分页栏展示
		$page -> setConfig('prev','上一页');
		$page -> setConfig('next','下一页');
		$page -> setConfig('first','首页');
		$page -> setConfig('last','尾页');
		$page -> setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$page -> rollPage = 6;
		$page -> lastSuffix = false;
		$page_html = $page ->show();
		$this->assign('page_html',$page_html);
		if (!empty($content)) {
			$page->firstRow=0;
		}
		
		$data = $model->field('*')->where($map)->limit($page->firstRow, $page->listRows)->select();
		// 变量赋值
		// echo $model->getLastSql();
		$this ->assign('data',$data);
		// dump($data);die;
		$this -> display();
	}
	public function del(){
		$id = I('get.id');
		// dump($id);die;
		$model = D('cate');
		$res =$model ->where(['id' => $id]) ->delete();
		// dump($res);die;
		if($res){
			// 删除成功
			$this ->success('删除成功', U('Admin/Type/index'));
		}else{
			// 如果删除失败！、
			$this ->error('删除失败！');
		}
	}
	public function edit(){
		if(IS_POST){
			$data =I('post.');
			// dump($data);die;
			// 把修改后的信息保存进数据库
			$model =D('cate');
			$res =$model ->save($data);
			if($res !==false){
				// 成功
				$this ->success('修改成功！',U('Admin/Type/index'));
			}else{
				// 失败
				$this ->error('修改失败！');
			}
		}else{
		$id =I('get.id');
		$model =D('cate');
		$data =$model -> where(['id' => $id]) -> find();
		// dump($data);die;
		$this ->assign('data',$data);
		$this ->display();
		}
	}
	public function ajaxindex(){
		$data = I('post.');
		$model=D('cate');
		// $data =$model ->select();
		$content = $data['content'];
		$page = $data['page'];
		// $this->assign('content',$content);
		$map['cate_name'] = array('like','%'.$content.'%');
		$total =$model ->where($map)->count();
		$pagesize = 2;
		$page = ($page-1) * $pagesize; 
		 
		
		 $data = $model->field('*')->where($map)->limit($page, $pagesize)->select();
		//$data = $model->field('*')->where($map)->select();
		$list ='';
		// foreach ($data as $k => $v) {
		// 	echo $v['id'];
		// }
		if($data){
			foreach ($data as $k => $v) {
				$list .= "<tr class='info'>";
	            $list .= "<td>{$v['id']}</td>";
	            $list .= "<td>{$v['cate_name']}</td>";
	            $list .= "<td>{$v['cate_desc']}</td>";                      
	            $list .= "<td>";
	            $list .= "<a href='".__CONTROLLER__."/edit/id/{$v['id']}'> 编辑 </a>";
	            $list .= "<a href='".__CONTROLLER__."/del/id/{$v['id']}''> 删除 </a>";
	            $list .= "</td>";
	            $list .= "</tr>";
            }
			$return = [
				'code' => 10000,
				'msg' =>'success',
				'list'=> "$list",
				'page_html'=>$page_html
			];
			$this->ajaxReturn($return);
		}else{
			$return = [
				'code' => 10001,
				'msg' =>'参数错误'
			];
			$this->ajaxReturn($return);
		}
		// 变量赋值
		// echo $model->getLastSql();
		// $this ->assign('data',$data);
		// dump($data);die;
		// $this -> display();
	}
	public function index(){
		$this->display();
	}
	public function count(){
		$model=D('cate');
		$content = I('post.content');
		$map['cate_name'] = array('like','%'.$content.'%');
		$total =$model ->where($map)->count();
		$pagesize = 2;
		$count=$total / $pagesize;
		$count =ceil($count);
		$this->ajaxReturn($count);
	}
}