<?php 
namespace Admin\Controller;
use Think\Controller;
class CateController extends CommonController{
	public function add(){
		if (IS_POST) {
			$data=I('post.');
			// dump($data);die;
			$model=D('Cate');
			$res=$model->add($data);
			if ($res) {
				$this->success('新增成功',U('Admin/Cate/lists'));
			}else{
				$this->error('新增失败！');
			}
		}else{
			$this ->display();
		}
	}
	public function lists(){
		$model=D('cate');
		$data =$model ->select();
		// 变量赋值
		$this ->assign('data',$data);
		// dump($data);die;
		$this -> display();
	}
	public function delete(){
		$id = I('get.id');
		// dump($id);die;
		$model = D('cate');
		$res =$model ->where(['id' => $id]) ->delete();
		// dump($res);die;
		if($res){
			// 删除成功
			$this ->success('删除成功', U('Admin/Cate/lists'));
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
			$model =D('Cate');
			$res =$model ->save($data);
			if($res !==false){
				// 成功
				$this ->success('修改成功！',U('Admin/Cate/lists'));
			}else{
				// 失败
				$this ->error('修改失败！');
			}
		}else{
		$id =I('get.id');
		$model =D('Cate');
		$Cate =$model -> where(['id' => $id]) -> find();
		// dump($goods);die;
		$this ->assign('Cate',$Cate);
		$this ->display();
		}
	}
}