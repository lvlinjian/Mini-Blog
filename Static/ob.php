<?php 
ob_start();
echo "123";

// $str=ob_get_contents();
$str=ob_get_clean();

echo($str);