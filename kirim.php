<?php
// *** LOAD PAGE HEADER
include "header.php";
include"right.php";
include "left.php";
?>
<?php
echo'
<div class="cleared"></div>


    <form method="post">
    <input type="hidden" name="info_belanja" value="'.htmlentities($checkout_cnt).'">
    <table id="kirim" border=0 cellspacing=0 cellpadding=0>
    <tr><td>Name : </td><td><input name="namalengkap" class="texbox" value="'.$_POST['namalengkap'].'">'.$err['namalengkap'].'</td></tr>
    <tr><td>Email : </td><td><input name="email" class="texbox" value="'.$_POST['email'].'">'.$err['email'].'</td></tr>
    <tr><td>Telp/HP : </td><td><input name="telphp" class="texbox" value="'.$_POST['telphp'].'">'.$err['telphp'].'</td></tr>
    <tr><td>Address :</br><small>Street, City, Country</small></td><td><textarea name="alamat" rows=4 cols=40 class="texarea">'.$_POST['alamat'].'</textarea>'.$err['alamat'].'</td></tr>
    <tr><td>Type the Code</br>on input box below</td><td>
        <img src="captcha.php?rand=" id="captchaimg" style="float:left;margin:6px 4px 0 0;border:1px dashed #000;">
        <small style="float:left">can not read?</br><a href=\'javascript: refreshCaptcha();\'>retry</a> another code</small>

        <script language="JavaScript" type="text/javascript">
            function refreshCaptcha()
            {
                var img = document.images[\'captchaimg\'];
                img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
            }
        </script>
        <div class="cleared"></div>
        <input id="sixletterscode" name="sixletterscode" type="text"  maxlength="6"
       class="texarea" style="width:360px;height:60px;font-family:FontCaptcha;font-size:44px;color:#009;text-align:center;">
        '.$err['sixletterscode'].'</td></tr>

    <tr><td></td><td><input type="hidden" name="act" value="order">
    <input type="submit" value="SEND" class="btn">
    <input type="reset" value="CLEAR" class="btn"></td></tr>
    </table></form>';
    
    ?>
    
<?php
echo '&nbsp;<div class="cleared"></div>';

// *** LOAD PAGE FOOTER
include "footer.php";

?>
