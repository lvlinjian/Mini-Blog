<?php
namespace Home\Controller;
use Think\Controller;
use Tools\Parsedown;
class IndexController extends Controller {
    // 文章的所有状态码：0，待审核；1，已审核；2，已加密；3，已拉黑；4，已删除
    const shenhe = 1;
    // 首页数据
	public function index(){
        $rurl = $_SERVER['HTTP_REFERER']; //获取反向链路
        $this->backLink($rurl);// 回链相关操作
                // echo session('manager_info.id');
        // 天气预报测试
		$count=file_get_contents('Public/log/api_tq_count.txt');
		$this ->assign('count',$count);
        // 博文内容
        $model = D('article');
        // 取最新回复的前10条数据的标题
        $top10 = $model 
            ->where('shenhe = 1') 
            ->field("title,id") 
            ->order("update_time  desc") 
            ->limit(10) 
            ->select();
        // $data= $model->order("字段名  desc [ 字段名  asc]")->select()[取一条数据：->find()];
        // 统计博文总条数
        /**
         * 统计博文总条数，并计算分页信息
         * @pgCount [int]   [总条数]
         * @page    [Obj]   [分页对象]
         */
        // 只能用纯数字 id 字段进行判断条数,排除审核中的“零”状态
        $pgCount= $model ->where('shenhe = 1') ->count('id');
        $limts = 10;//每页显示多少条数据
        $page = new \Tools\page($pgCount,$limts,'',true);
        /**
         * 获取博文内容
         * order                [升降序]
         * @$page->listRows     [int]       [每页显示条数]
         * @sPage               [int]       [从第几页开始]
         */
        // dump($sPage);die;
        // 引入 Parsedown （PHP-markdown解析器）,并实例化
        // 自动加载类
        // include_once './public/md/Parsedown.php';
        $Parsedown = new Parsedown();

        // 查询并遍历数据,排除审核中的“零”状态
        $data= $model ->alias("a") ->where('shenhe = 1') ->field("a.*,u.nickname") ->join("left join zebra_manager as u on a.user_id = u.id") ->order("a.update_time  desc") ->limit($page->offset,$limts) ->select();//a.id,a.title,a.cate_id,a.content,a.md,a.shenhe,a.hits,a.update_time,a.create_time
        // dump($page);die;

        foreach ($data as $k=> $v) {
            $data[$k]['create_time'] = date('Y-m-d',$v['create_time']);
            $data[$k]['update_time'] = date('Y-m-d H:i',$v['update_time']);

            // dump($data);die;
            if ($data[$k]['md'] === "1") 
            {
                // 如果 md 字段为真，则执行 md 解析：
                $strings = html_entity_decode($v['content']);
                // $data[$k]['content'] = $Parsedown->text($strings);
                // 2018年5月30日，提取文章摘要，cutstr()方法定义在funtion.php文件中
                $data[$k]['content'] = cutstr($Parsedown->text($strings));
                    // $file = 'Public/md/temp.md';
                    // 字符串写进临时文件中
                    // file_put_contents($file, $strings);
                    // echo file_get_contents($file);die;
            }
            else
            {
                // 否则，解析特殊字符
                // $v['content']=html_entity_decode($v['content']);
                // $data[$k]['content'] = html_entity_decode($v['content']);
                // 2018年5月30日，提取文章摘要，cutstr()方法定义在funtion.php文件中
                $data[$k]['content'] = cutstr(html_entity_decode($v['content']));
            }

            // dump($data);die;
        }
        $param['where'] = 'deldate=0';
        $links = D('Admin/Link')->getDatas($param,'id asc',50);// 友情链接
        // dump($links);die;
        $this->assign('links',$links);
        $this->assign('shenhedata',$shenhedata);
        $this->assign('top10',$top10);
        $this->assign('data',$data);
        $this->assign('page',$page->fpage());
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
        $arr2[]=$b["now"]["wind_dir"]." "; // 风向
        $arr2[]=$b["now"]["wind_sc"]."级<br>";
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
    // 详情页（阅读全文）
    public function detail(){
        // 接收文章ID
        $id = $_GET["id"];
        // 博文内容
        $model = D('article');

        // 访问量自增1
        $model -> where("id = $id") ->setInc('hits',1);

        // 取1条数据
        $top1 = $model 
            ->alias("a")  
            ->where(['a.id' => $id, 'shenhe' => ['EQ',self::shenhe]]) // EQ 等于
            ->field("a.*,u.nickname") 
            ->join("left join zebra_manager as u on a.user_id = u.id")  
            ->find();
        $top1['create_time'] = date('Y-m-d',$top1['create_time']); 
        $top1['update_time'] = date('Y-m-d H:i',$top1['update_time']);
        if ($top1['md'] === "1") 
        {
            // 如果 md 字段为真，则执行 md 解析：
            $Parsedown = new Parsedown();
            $strings = html_entity_decode($top1['content']);
            $top1['content'] = $Parsedown->text($strings);
        }
        else
        {
            // 否则，解析特殊字符
            $top1['content']=html_entity_decode($top1['content']);
        }
        // dump($top1);die;
        $this->assign('top1',$top1);
        $this ->display();
    }
    /**
     * 友情链接访问量+1
     * @author TabKey9 <Admin@tlip.cn>
     * @date        2018-09-05
     * @param string $id 链接的ID 
     * @return void
     */
    public function clickLink(){
        $id = I('get.id');
        if (empty($id)) {
            return;
        }
        $param['where'] = "id=$id";// 自增条件
        $param['function'] = 'setInc';// 字段自增运算
        $param['rank'] = 'click';// 字段名
        $param['num'] = 1;// 自增量            
        $res = D('Admin/Link')->clickAccess($param);
        // var_dump($res);
        if ($res < 0 || $res == false) {
            $msg['code'] = 'false';
            $msg['msg'] = 'erroe';
            $msg['data'] = $res;
        }else{
            $msg['code'] = 'true';
            $msg['msg'] = 'success';
            $msg['data'] = $res;
        }
        header("Content-type:text/json;charset=UTF-8");
        echo json_encode($msg);
    }
    /**
     * 获取来访链接，如果是友情链接，则对应字段+1
     * @author TabKey9 <Admin@tlip.cn>
     * @date        2018-09-05
     * @param string $rurl 来源地址
     * @return void
     */
    public function backLink($rurl=''){
        if (empty($rurl)) {
            return;
        }
        // 字符串分割，取需要的部分
        $str = explode('/',$rurl);
        // var_dump($str['2']);// ***.**
        $param['where'] = 'POSITION(\''.$str['2'].'\' IN `url`)';// 自增条件:SELECT * FROM `zebra_link` WHERE POSITION('hu60.net' IN `url`);
        $res = D('Admin/Link')->getOneData($param);// 先判断是否存在数据表中
        if ($res < 0 || $res == false) {
            return;
        }else{
            $id = $res['id'];// 获取友情链接ID
            $param['where'] = "id=$id";// 自增条件
            $param['function'] = 'setInc';// 字段自增运算
            $param['rank'] = 'returl';// 字段名
            $param['num'] = 1;// 自增量            
            $res1 = D('Admin/Link')->clickAccess($param);
        }
    }
}