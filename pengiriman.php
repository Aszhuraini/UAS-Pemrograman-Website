<div id="kirim2">
    <h3 align="center">ALAMAT PENGIRIMAN</h3>
    <hr>
    <form method="post">
    <input type="hidden" name="info_belanja" value="'.htmlentities($checkout_cnt).'">
    <table id="fr_delivery" border=0 cellspacing=0 cellpadding=0>
    <tr><td class="ck"><b>Name : </td><td class="cv"><input name="namalengkap" class="mytextinp" value="'.$_POST['namalengkap'].'">'.$err['namalengkap'].'</td></tr>
    <tr><td class="ck"><b>Email : </td><td class="cv"><input name="email" class="mytextinp" value="'.$_POST['email'].'">'.$err['email'].'</td></tr>
    <tr><td class="ck"><b>Telp/HP : </td><td class="cv"><input name="telphp" class="mytextinp" value="'.$_POST['telphp'].'">'.$err['telphp'].'</td></tr>
    <tr><td class="ck"><b>Address :</br><small><b>Street, City, Country</small></td><td class="cv"><textarea name="alamat" rows=4 cols=40 class="mytextinp">'.$_POST['alamat'].'</textarea>'.$err['alamat'].'</td></tr>
    <tr><td class="ck"></td><td class="cv">
        <img src="captcha.php?rand=" id="captchaimg" style="float:left;margin:6px 4px 0 0;border:1px dashed #000;">
        <small style="float:left">Tidak Bisa Dibaca?</br><a href=\'javascript: refreshCaptcha();\'>Coba</a> Kede Lain</small>
        <script language="JavaScript" type="text/javascript">
            function refreshCaptcha()
            {
                var img = document.images['captchaimg'];
                img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
            }
        </script>
        <div>';

       <div class="cleared"></div>
        <input id="sixletterscode" name="sixletterscode" type="text"  maxlength="6"
        class="mytextinp" style="width:160px;height:60px;font-family:FontCaptcha;font-size:44px;color:#2c7b8f;text-align:center;">
        '.$err['sixletterscode'].'</td></tr>

    <tr><td></td><td><input type="hidden" name="act" value="order">
    <input type="submit" value="SEND" class="mybutton">
    <input type="reset" value="CLEAR" class="mybutton"></td></tr>
    </table>
    <a href="index.php" id="lagi">&laquo; Lanjutkan Belanja</a>
    <a href="input_regis.php" id="lagi">&laquo;Daftar</a>

</div>

