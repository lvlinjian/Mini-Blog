<?php 
namespace Home\Model;
use Think\Model;
class ManagerModel extends Model{
//    protected $patchValidate = true;
    protected $_validate = array(
        array('username','require','用户名必须！'), //默认情况下用正则进行验证
        array('username','/^[a-zA-Z][a-zA-Z0-9_]{4,15}+$/','必须字母开头，允许5-16字节，允许字母数字下划线'),
        array('username','','用户名已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('nickname','','昵称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('password','require','密码必须！'), //默认情况下用正则进行验证
//        array('password','6,12','密码长度为6-12位',1,'length',1), // 自定义函数验证密码格式
        array('password','/^[A-Za-z0-9_]+$/','密码可使用范围：英文、数字、下划线！')//密码限制格式
    );
}