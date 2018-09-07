<?php
namespace Admin\Model;
use Think\Model;
/**
 * Link 数据表操作模型 - CURD
 */
class LinkModel extends Model
{
	public function addData($param){
		// 新增数据
		return $this->add($param);
	}
	public function saveData($param){
		// 修改数据
		return $this->save($param);
	}
	public function getDatas($param,$order='id desc',$limit=10){
		// 查看列表
		return $this->where($param['where'])
		->order($order)
		->limit($limit)
		->select();
	}
	public function getOneData($param){
		// 查看一条数据
		return $this->where($param['where'])
		->find();
	}
	public function delOneData($param){
		// 删除一条数据 - 真删
		return $this->where($param['where'])
		->delete();
	}
	public function delDatas(){
		// 删除所有数据 - 真删
		return $this->where('1=1')
		->delete();
	}
	public function falseDelOneData($param){
		// 删除一条数据 - 假删
		return $this->save($param);
	}
	public function falseDelDatas($param){
		// 删除所有数据 - 假删
		return $this->where('1=1')
		->save($param);
	}
	public function clickAccess($param){
		// 数字类,字段增减操作
		return $this->where($param['where'])
		->$param['function']($param['rank'],$param['num']);// 字段运算
	}
}