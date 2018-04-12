<?php 
namespace Admin\Model;
use Think\Model;
class BlogModel extends Model{
	public function insert($data){
		$sql = "insert into article (title,cate_id,content,pubtime)";
		$sql = "values('{$data['title']}',{$data['cate_id']},'{$data['content']}',now());";
		return $this->pdo->exec($sql);

	}
	public function getCateList(){
		$model=D('cate');
		$data =$model ->select();
		return $data;
	}
}





 ?>