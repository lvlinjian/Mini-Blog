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

/**
  php摘要生成函数
  link：http://www.jquerycn.cn 2013-3-7
  @TabKey9:	过滤掉html和php标签 && $s 变量未定义的解决方案。&& cutstr()加默认参数
*/
function cutstr($str, $length=256,$charset='utf-8',$dot='......') {//字符，截取长度，字符集，结尾符
$string = strip_tags("$str"); // 过滤掉html和php标签
if(strlen($string) <= $length) {
return $string;
}
$pre = chr(1);
$end = chr(1);
//保护特殊字符串
$string = str_replace(array('&', '"', '<', '>'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);
$strcut = '';
if(strtolower($charset) == 'utf-8') {
$n = $tn = $noc = 0;
while($n < strlen($string)) {
$t = ord($string[$n]);
if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
$tn = 1; $n++; $noc++;
} elseif(194 <= $t && $t <= 223) {
$tn = 2; $n += 2; $noc += 2;
} elseif(224 <= $t && $t <= 239) {
$tn = 3; $n += 3; $noc += 2;
} elseif(240 <= $t && $t <= 247) {
$tn = 4; $n += 4; $noc += 2;
} elseif(248 <= $t && $t <= 251) {
$tn = 5; $n += 5; $noc += 2;
} elseif($t == 252 || $t == 253) {
$tn = 6; $n += 6; $noc += 2;
} else {
$n++;
}
if($noc >= $length) {
break;
}
}
if($noc > $length) {
$n -= $tn;
}
$strcut = substr($string, 0, $n);
} else {
for($i = 0; $i < $length; $i++) {
$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
}
}
//还原特殊字符串
$strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&', '"', '<', '>'), $strcut);
//修复出现特殊字符串截段的问题
$s = null; // $s 变量未定义的解决方案。
$pos = strrpos($s, chr(1));
if($pos !== false) {
$strcut = substr($s,0,$pos);
}
return $strcut.$dot;
}
// 调用例子
// echo cutstr('输入字符串');
// return cutstr('输入字符串');

/**
 * 生成随机字符串
 *
 * @access public
 * @param integer $length 字符串长度
 * @param boolean $specialChars 是否有特殊字符
 * @return string
 */
function randString($length, $specialChars = false)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    if ($specialChars) {
        $chars .= '!@#$%^&*()';
    }

    $result = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[rand(0, $max)];
    }
    return $result;
}

/**
 * 处理XSS跨站攻击的过滤函数
 *
 * @author kallahar@kallahar.com
 * @link http://kallahar.com/smallprojects/php_xss_filter_function.php
 * @access public
 * @param string $val 需要处理的字符串
 * @return string
 */
function removeXSS($val)
{
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   $val = preg_replace('/([\x00-\x08]|[\x0b-\x0c]|[\x0e-\x19])/', '', $val);

   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';

   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

      // &#x0040 @ search for the hex values
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // &#00064 @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[xX]0{0,8}([9ab]);)';
               $pattern .= '|';
               $pattern .= '|(&#0{0,8}([9|10|13]);)';
               $pattern .= ')*';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags

         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }

   return $val;
}

/**
 * 对xss字符串的检测
 *
 * @access public
 * @param string $str
 * @return boolean
 */
function xssCheck($str)
{
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';

    for ($i = 0; $i < strlen($search); $i++) {
        // ;? matches the ;, which is optional
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

        // &#x0040 @ search for the hex values
        $str = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $str); // with a ;
        // &#00064 @ 0{0,7} matches '0' zero to seven times
        $str = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $str); // with a ;
    }

    return !preg_match('/(\(|\)|\\\|"|<|>|[\x00-\x08]|[\x0b-\x0c]|[\x0e-\x19]|' . "\r|\n|\t" . ')/', $str);
}
