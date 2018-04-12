<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    // 首页数据
	public function index(){
        // 天气预报测试
		$count=file_get_contents('Public/log/api_tq_count.txt');
		$this ->assign('count',$count);
        // 博文内容
        $model = D('article');
        // $data= $model->order("字段名  desc [ 字段名  asc]")->select()[取一条数据：->find()];
        // 统计博文总条数
        /**
         * 统计博文总条数，并计算分页信息
         * @pgCount [int]   [总条数]
         * @page    [Obj]   [分页对象]
         */
        $pgCount= $model->where("title")->count();
        $page = new \Think\Page($pgCount,2);
        $page -> setConfig('prev','上一页');
        $page -> setConfig('next','下一页');
        $page -> setConfig('first','首页');
        $page -> setConfig('last','尾页');
        $page -> setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');//自定义输出模板  
        $show = $page->show();
        /**
         * 获取博文内容
         * order                [升降序]
         * @$page->listRows     [int]       [每页显示条数]
         * @sPage               [int]       [从第几页开始]
         */
        $sPage = empty($_GET["p"]) ? 0 : $_GET["p"];
        // 解决奇怪的分页bug,但是数据库第一条始终拿不到
        if ($sPage == 1) {
            $sPage = 0;
        }
        $data= $model->order("pubtime  desc")->limit($sPage,$page->listRows)->select();//

        // echo "<pre>";var_dump($data);die();
        foreach ($data as $k=> $v) {
            // $v['content']=html_entity_decode($v['content']);
            $data[$k]['content'] = html_entity_decode($v['content']);
            // dump($v);die;
        }
        $this->assign('data',$data);
        $this->assign('page',$show);
        // echo "<pre>";
        // print_r($_GET["p"]);die();
        // 页脚响应时间
        $times ='效率: '.G('begin','end','3').'s';
        G('end');
        $this ->assign('times',$times);
        // 展示数据
		$this ->display();
	}
    public function register(){

        $model = D('manager');
        $data =I('post.');
        if($this->check_verify($data['code'])){

            $user = $model->create($data);
            if(!$user){
                $this->error($model->getError(),U("index"));
            }else{
                $model->update_time = time();
                $model->password = md5_password($user['password']);
                if($model->add()){
                    $this->success('恭喜您注册成功，快去登录吧！',U("admin/login/index"));
                }else{
                    $this->error('对不起，注册失败！',U("index"));
                }
            }
        }else{
            $this->error('验证码错误',U("index"));
        }

    }
    public function api_tq(){
        // echo "this is test!";die;
        // $stime=microtime(true); // time
        // 和风天气API 
        $url ="https://free-api.heweather.com/s6/weather/now?key=84d56848cbcf440c94c75ed8964e8f9d&location=";
        $url2 =I('get.city');
        // 简单的防注入正则过滤
        $ze='/^[^\'\"^`]+$/i';
        $ze=preg_match($ze,$url2);
        // 修改默认值，拿用户真实IP去查天气
        $user_ip=get_client_ip();
        if(empty($user_ip) || $user_ip=='127.0.0.1') $user_ip='beijing';
        // 判断用户是否传参数city
        if(!$ze) $url2 = $user_ip;
        // dump($url2);die;
        // 创建一个新cURL资源
        $ch = curl_init();
        //设置头信息
        $headers=array( "Accept: application/json", "Content-Type: application/json;charset=utf-8" );
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url.$url2);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,$headers);// 不直接输出到浏览器
        // 抓取URL并把它传递给浏览器
        $arr =curl_exec($ch);
        // $etime=round(microtime(true)-$stime,3); //time
        // 统计
        $file = 'Public/log/api_tq_count.txt';
        $current = file_get_contents($file);
        $current+=1;
        file_put_contents($file, $current);
        // 数据处理
        $a=json_decode($arr,true);
        $b=$a['HeWeather6'][0];
        // print_r($b);die;
        $arr2=array();
        if($b['status']!='ok'){
            $arr2[]='未知城市！';
            $arr2[]="累计请求 ".$current." 次<br>";
        }else{
        $arr2[]=$b["basic"]["location"]."<br>"; // 城市
        $arr2[]=$b["now"]["cond_txt"]." | "; // 天气
        $arr2[]=$b["now"]["wind_dir"]."<br>"; // 风向
        $arr2[]=$b["now"]["wind_sc"]." | ";
        $arr2[]=$b["now"]["wind_spd"]." km/h<br>";
        $arr2[]="当前 ".$b["now"]["tmp"]." ℃ | ";
        $arr2[]="体感 ".$b["now"]["fl"]." ℃<br>";
        $arr2[]="累计请求 ".$current." 次";
        }
        header("Content-type:text/json;charset=UTF-8");
        $data= json_encode($arr2,JSON_UNESCAPED_UNICODE);
        echo($data);
        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);
    }
	// 验证码生成
    public function Verify(){
        $Verify =     new \Think\Verify();
        $Verify->codeSet = '0123456789';
        $Verify->length   = 4;
        $Verify->fontttf = '5.ttf';
        $Verify->useNoise = false;
        $Verify->bg = array(238,238,238);
        $Verify->entry();
    }
//    验证码判断
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
}