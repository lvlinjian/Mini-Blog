<?php
namespace Admin\Controller;
use Think\Controller;
use Tools\Parsedown;
class IndexController extends CommonController{
    // 文章的所有状态码：0，待审核；1，已审核；2，已加密；3，已拉黑；4，已删除
    const shenhe = 3;
	public function index(){
		// $this ->display();
        // 博文内容
        $model = D('article');
        // 取最新回复的前10条数据的标题
        $top10 = $model 
        	->where(['shenhe' => ['LT',self::shenhe]]) 
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
        //0、审核中， 1,通过，2、加密，3，黑名单；4、软删除
        $pgCount= $model 
            ->where(['shenhe' => ['LT',self::shenhe]]) 
            ->count('id');
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

        // 查询并遍历数据
        $data= $model
	        ->alias("a") 
	        ->where(['a.shenhe' => ['LT',self::shenhe]]) 
	        ->field("a.*,u.nickname") 
	        ->join("left join zebra_manager as u on a.user_id = u.id") 
	        ->order("a.update_time  desc") 
	        ->limit($page->offset,$limts) 
	        ->select();//a.id,a.title,a.cate_id,a.content,a.md,a.shenhe,a.hits,a.update_time,a.create_time
        // dump($page);die;
// 定义一条动态的审核提示信息，只要有任何一条需要审核的数据存在，则在首页置顶该信息，用于实时监听审核状态，以及友好的提示信息。
        // 只能用纯数字 id 字段进行判断条数,排除审核中的“零”状态
        $shenheing= $model ->where('shenhe = 0') ->count('id');
            if ($shenheing > 0) {
                # 拼接数据
                $shenhedata['update_time'] = date('今天 H时i分',time());
                $shenhedata['title'] = "温馨提示：有 $shenheing 篇文章等待审核！ ";
                $shenhedata['content'] = $Parsedown->text(html_entity_decode("###<code>审核员</code>不在线，有 $shenheing 篇文章未能及时完成审核！\r\n>* 管理员采用人工审核机制，请您耐心等候！\r\n>* 已经发送通知信息给<code>审核员</code>的微信公众号!\r\n>* 如果当天未能审核通过，请您核对文章内容是否<code>违规</code>！"));
            }
            // var_dump($shenhedata);die;
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
        // dump($data);die;
        $this->assign('shenhedata',$shenhedata);
        $this->assign('top10',$top10);
        $this->assign('data',$data);
        $this->assign('page',$page->fpage());
        // echo "<pre>";
        // print_r($_GET["p"]);die();
        // 展示数据
		$this ->display();
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
            ->where(['a.id' => $id, 'shenhe' => ['LT',self::shenhe]]) // LT 小于
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
}