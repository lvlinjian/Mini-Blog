<?php 
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends CommonController{
	// 文章添加
	public function add(){
		// die('this is test!');
		if (IS_POST) {
			$data = I('post.');
			// dump($data);die;
			if($data['title']&&$data['cate_id']&&$data['content']){
				$data['pubtime'] = date('Y/m/d H:i:s');
				// dump($data);die;
				$res = D('Article') ->add($data);
				if ($res !==flase) {
					$this->success('新增成功',U('Admin/Article/index'));
				}else{
					$this->error('新增失败！');
				}
			}else{
		
				$this->error('参数不足！');die;
			}
			$data['article_content']= I('post.content','','trim');

			
		}else{
		$model = D('cate');
		$data=$model->select();
		$this->assign('data',$data);
		$this->display();
		}
	}
	public function index(){
			$model = D('article');
			$data= $model->select();
			$this->assign('data',$data);
		$this -> display();
	}
	public function del(){
			$id = I('get.id');
			$model=D('Article');
			$res=$model->where(['id' => $id]) ->delete();
			if ($res) {
				$this->success('删除修改',U('Admin/Article/index'));
			}else{
				$this->error('删除失败！');
			}

	}
	public function edit(){
		if(IS_POST){
		// die('this is test!');
			$data =I('post.');
			// dump($data);die;
			// 把修改后的信息保存进数据库
			$model =D('Article');
			$res =$model ->save($data);
			if($res !==false){
				// 成功
				$this ->success('修改成功！',U('Admin/Article/index'));
			}else{
				// 失败
				$this ->error('修改失败！');
			}
		}else{
		$id =I('get.id');
		$model =D('Cate');
		$cate=$model -> select();
		$this ->assign('cate',$cate);
		// select a.*,b.cate_name from zebra_article as a left join zebra_cate as b on a.cate_id = b.id where a.id = 25 ;
		// $res= D('Article')->field('')->where(['zebra_article.id' => $id])->join('zebra_cate on zebra_article.cate_id=zebra_cate.id')->find()->fetchSql();
		$res = D("Article")->alias("a")->field("a.*,b.cate_name")->join("left join zebra_cate as b on a.cate_id = b.id")->where("a.id = $id") ->find();
		// echo "<pre>";
		// var_dump($res);die;
		$this ->assign('res',$res);
		$this ->display();
		}
	}
}