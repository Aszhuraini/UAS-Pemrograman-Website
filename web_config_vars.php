<?php
'echo<div id="login">';
// *** CONFIGURATION VARS
$web_title  = "Web Online Shop V3 Demo";
$db_host    = "localhost";
$db_user    = "root";
$db_pass    = "";
$db_name    = "toko_online";

$currency_prefix = "Rp. ";
$currency_postfix = ",-";
function format_currency($v){
    global $currency_prefix,$currency_postfix;
    return $currency_prefix.number_format($v,0,"",".").$currency_postfix;
}

function is_active($v){
    global $_SERVER;
    $filename=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],"/")+1);
    if ($v==$filename) return ' class="aktif" ';
}
?>
