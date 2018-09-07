<?php 
/**
 * 为了支持 MD 模式而 copy 的博文管理模块
 */
namespace Admin\Controller;
use Think\Controller;
class BlogController extends CommonController{
	// 定义类常量，当前模块数据为md模式，用字符串1表示
	const md = '1';
	// 文章的所有状态码：0，待审核；1，已审核；2，已加密；3，已拉黑；4，已删除
	const shenhe = 3;
	// add
	public function add(){
		// die('this is test!');
		if (IS_POST) {
			// 过滤用户输入的内容
			$data = I('post.','','trim');
			// dump($data);die;
			if($data['title']&&$data['cate_id']&&$data['content']&&$data['md']==='1'){
				// 记录时间戳
				$data['update_time'] = $data['create_time'] = time();//date('Y-m-d H:i:s')
				$model = D('article')->add($data);
				if ($model !== false) {
					$this->success('新增成功',U('Admin/Blog/index'));
				}else{
					$this->error('新增失败！');
				}
			}else{
		
				$this->error('参数不足！');die;
			}
			
		}else{
		$model = D('cate');
		$data=$model->select();
		$this->assign('data',$data);
		$this->display();
		}
	}
	// 列表
	public function index(){
			$model = D('article');
			// dump($this->user_id);// 从父类拿到用户id
			// 分用户、发布模式，进行文章管理操作
			// $data= $model ->where(['user_id' => $this->user_id, 'md' => self::md]) ->select();
			// 连分类表查询并展示分类名称
			$data= $model 
				->alias("a") 
				->where(['user_id' => $this->user_id, 'md' => self::md, 'shenhe' => ['LT',self::shenhe]]) 
				->field("a.id,a.title,c.cate_name,a.md,a.shenhe,a.hits,a.update_time") 
				->join("left join zebra_cate as c on a.cate_id = c.id") 
				->order("a.update_time  desc") 
				->select();//a.id,a.title,a.cate_id,a.content,a.md,a.shenhe,a.hits,a.update_time,a.create_time
			foreach ($data as $k => $v) {
				$data[$k]['update_time'] = date('Y-m-d H:i',$v['update_time']);
			}
			// dump($data);die;
			$this->assign('data',$data);
		$this -> display();
	}
	// 删除
	public function del(){
		$this->error('请改用软删除方式'); // 禁用真实的删除功能
		$id = I('get.id');
		$model=D('article');
		$res=$model ->where(['id' => $id, 'user_id' => $this->user_id, 'md' => self::md]) ->delete();
		if ($res) {
			$this->success('删除修改',U('Admin/Blog/index'));
		}else{
			$this->error("你只能删除【 $this->nickname 】的文章！");
		}
	}
	// edit
	public function edit(){
		if(IS_POST){
		// die('this is test!');
			$data =I('post.','','trim');
			// dump($data);die;
			if ( $data['user_id'] !== $this->user_id || $data['md'] !== self::md ) { 
				$this ->success('禁止编辑 别人的文章或者 富文本 模式的内容',U('Admin/Blog/index'),(int)4);
				die;
			}
			// 记录时间戳
			$data['update_time'] = time();//date('Y-m-d H:i:s')
			// 把修改后的信息保存进数据库
			$model =D('article')->save($data);
			if($model !==false){
				// 成功
				$this ->success('修改成功！',U('Admin/Blog/index'));
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
		// $res= D('article')->field('')->where(['zebra_article.id' => $id])->join('zebra_cate on zebra_article.cate_id=zebra_cate.id')->find()->fetchSql();
		// 自定义字段
		$res = D("article")
			->alias("a")
			->field("a.id,a.title,a.cate_id,a.content,a.md,a.user_id,b.cate_name")
			->join("left join zebra_cate as b on a.cate_id = b.id")
			->where(['a.id' => $id, 'a.shenhe' => ['LT',self::shenhe]]) 
			->find();
		// echo "<pre>";
		// var_dump($res);die;
		$this ->assign('res',$res);
		$this ->display();
		}
	}
	/**
	 * 文章状态码变更控制器
	 * 状态码参考：0，待审核；1，已审核；2，已加密；3，已拉黑；4，已删除；
	 * @author TabKey9 <Admin@tlip.cn>
	 * @date        2018-08-22
	 * @param array $id and $shenhe GET数组
	 * @return string 提示信息
	 */
	public function check(){
		$where['id'] = I('get.id');
		$where['shenhe'] = I('get.shenhe');
		// var_dump($where);
		$model = D('article')->checkM($where);
		if ($model) {
			$res = '操作成功！';
		}else{
			$res = '操作失败！';
		}
		$this->success($res,U('Blog/index'));
	}
}