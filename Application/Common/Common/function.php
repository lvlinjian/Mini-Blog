<?php 
G('begin'); //time
// 自定义密码加密函数
function md5_password($pwd){
	// 自定义需要拼接的字符串密钥
	$str ="zebra";
	return md5(md5($pwd).$str);
}
function CURL(){
	// 第一步初始化CURL_INIT;
	$ch =curl_init($url);
	// 第二步设置参数，
	if(IS_POST){
		curl_setopt($ch,CURLOPT_POST,true);
	}
	// 第三步发送请求
	
	// 第四步关闭请求
}

#递归方法实现无限极分类
function getTree($list,$pid=0,$level=0) {
    static $tree = array();
    foreach($list as $row) {
        if($row['pid']==$pid) {
            $row['level'] = $level;
            $tree[] = $row;
            getTree($list, $row['id'], $level + 1);
        }
    }
    return $tree;
}