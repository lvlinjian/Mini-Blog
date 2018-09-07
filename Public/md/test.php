<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 引入一个  github-markdown.css 样式-->
<link rel="stylesheet" href="github-markdown.css">
<style>
	.markdown-body {
		box-sizing: border-box;
		min-width: 200px;
		max-width: 980px;
		margin: 0 auto;
		padding: 45px;
	}

	@media (max-width: 767px) {
		.markdown-body {
			padding: 15px;
		}
	}
</style>
<article class="markdown-body">
<?php 
/**
 * 用于调用 Parsedown 的测试文件
 * @author TabKey9 <Admin@tlip.cn>
 * @date        2018-04-12
 * @anotherdate 2018-04-12 04:02:13
 */
// 引入 Parsedown （PHP-markdown解析器）
require_once './Parsedown.php';
// 实例化
$Parsedown = new Parsedown();
// 打开一个.md文件，或者 $file = "# Hello Words!";
$file = file_get_contents("./README.md");
echo $Parsedown->text($file);
?>
</article>
