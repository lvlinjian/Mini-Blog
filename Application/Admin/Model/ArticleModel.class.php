<?php 
namespace Admin\Model;
use Think\Model;
class ArticleModel extends Model{
	public function upload_logo(){
		// 将图片保存到服务器，并将缩略图保存到数据库
		$config =[
			'maxSize'	=>	6*1024*1024,// 上传大小限制
			'exts'	=>	array('jpg','png','gif','jpeg'),// 限制后缀名
			'rootPath'	=>	ROOT_PATH . UPLOAD_PATH,// 保存根路径
		];
		$upload =new \Think\Upload($config);// 调用Upload类 uploadOne方法（传递文件数组参数）
		// dump($upload);die;
		// dump($_FILES['goods_logo']);
		$res =$upload -> uploadOne($_FILES['goods_logo']);
		// dump($res);die;
		if(!$res){
			$this -> error = $upload -> getError();
			return false;
		}
		$logo = UPLOAD_PATH . $res['savepath'] . $res['savename'];
		$image = new \Think\Image();
		$image -> open('.' . $logo);
		$image -> thumb(200,200);
		$thumb_logo = UPLOAD_PATH . $res['savepath'].'thumb_' . $res['savename'];
		$data['goods_logo'] = $thumb_logo;
		return true;
	}
	/**
	 * 更新操作，只是针对部分字段进行局部更新。
	 * @author TabKey9 <Admin@tlip.cn>
	 * @date        2018-08-22
	 * @param array $where 条件可以是数组也可以是字符串
	 * @return string 返回一个状态
	 */
	public function checkM($where){
		// dump($where);die;
		// echo "string";return;
		$res = $this->setField($where);
		if ($res) {
			return $res;
		}else{
			return $res;
		}
	}
}