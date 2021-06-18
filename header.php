<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
// *** LOAD SESSION
session_start();
// *** LOAD CONFIGURATION VARS
include "web_config_vars.php";
// *** DB CONNECTION
include "db_conn.php";
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Belanja Online</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="en-us,id">
<meta name="keywords" content="Your Keyword" />
<meta name="description" content="Your Descripton" />
<meta name="robots" content="index,follow">
<meta name="Generator" content="umkm">
<meta name="Author" content="Your Name">
<meta name="revisit-after" content="2 days">
<meta NAME="Rating" CONTENT="General">
<meta NAME="Distribution" CONTENT="Global">
<link rel="shortcut icon" href="images/pavicon.ico" >
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="shortcut icon" href="images/favicon.png">

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


<!-- Start Slider HEAD section --> <!-- add to the <head> of your page -->
	<link rel="stylesheet" type="text/css" href="engine1/style.css" />
	<script type="text/javascript" src="engine1/jquery.js"></script>
	<!-- End Slider.com HEAD section -->





<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<style>
#bgmenu{
    background:#0096D6;
    height:26px;
    width:100%;
    padding-top:5px;
}

</style>


<div id="header"><!--start header-->

<div id="header_content">	<!--start header conteent-->
	<ul>

	  <li><a href="index.php?clear=y"><img width="300px" alt="" title=""></a></li>
	  <li> <?php
		  echo'<form method="post" action="list_barang.php">
			     <input class="btncari" type="submit" value=""><input class="texbox_cari" name="cari" value="'.$_SESSION[cari].'" placeholder="Search" >
			   </form>';
	   ?></li>

	<li><?php include"cart.php";?></li>
   </ul>
</div><!--End header conteent-->




     </div><!--end header-->

<div id="container"><!--start container-->
<div class="cleared"></div>
