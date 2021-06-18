<?php
// *** LOAD PAGE HEADER
include "header.php";
include"right.php";
include "left.php";
?>
<script type="text/javascript">
function HanyaAngka(evt)
{
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))

return false;
return true;
}
</script>

<?php
if ($_POST['act']=="add"){


$cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM daftar_order WHERE kode_order ='".$_POST['kode_order']."'");

$num_row = mysqli_num_rows($cek);
if (empty($_POST['kode_order'])) $err['kode_order']="<span class=\"err\">Kode Order Tidak Boleh Kosong</span>\n";
elseif ($num_row ==0){
     echo'<script>alert("Kode Order Yang Anda Masukkan Salah");window.location ="konfirmasi.php";</script>';
}

    if (empty($_POST['tanggal'])) $err['tanggal']="<span class=\"err\">Tanggal Tidak Boleh Kosong</span>\n";
    if (empty($_POST['nama_pemilik'])) $err['nama_pemilik']="<span class=\"err\">Nama Pemilik Rekening Tidak Boleh Kosong.</span>\n";
    if($_POST['nama_bank']=='pilih') $err['nama_bank']="<span class=\"err\">Nama Bank Harus Dipilih</span>\n";
    if (empty($_POST['jumlah_transfer'])) $err['jumlah_transfer']="<span class=\"err\">Jumlah Transfer Tidak Boleh Kosong.</span>\n";
    if (empty($_POST['alamat'])) $err['alamat']="<span class=\"err\">Silahkan Lengkapi Alamat pengiriman barang Anda.</span>\n";
     if (empty($_FILES['gambar']['name'])) $err['gambar']="<span class=\"err\">Gambar Tidak Boleh Kososng</span>\n";
    if ($_POST['sixletterscode']<>$_SESSION['6_letters_code']) $err['sixletterscode']="<span class=\"err\">Validasi Yang Anda Masukkan Salah.</span>\n";

    if(count($err)>0){ // *** if submit error
        echo "<div id='notif2'>Data Yang Anda Masukkan Masih Ada Yang Salah, Silahkan Perbaiki, Terima Kasih</div>";
    }

else{
    $sql_add="INSERT INTO konfirmasi (kode_order,tanggal,nama_pemilik,nama_bank,jumlah_transfer,alamat_kirim) VALUES ("
    ."'".$_POST['kode_order']."',
    '".$_POST['tanggal']."',
    '".$_POST['nama_pemilik']."',
    '".$_POST['nama_bank']."',
     '".$_POST['jumlah_transfer']."',
    '".$_POST['alamat']."') ";
    @mysqli_query($GLOBALS["___mysqli_ston"], $sql_add);

if( !empty($_FILES['gambar']['name']) )
    {
    $path = "gambar/";
    $lastid=@mysqli_result(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_konfirmasi FROM konfirmasi ORDER BY id_konfirmasi DESC LIMIT 0,1"), 0, 0);
    $new_image_name = $lastid.".jpg";
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, $path.$new_image_name);
    }

   echo'<script>alert("Terima Kasih  Customer Service Kami Akan segera Menghubungi Saudara '.$_POST['nama_pemilik'].'");window.location ="index.php";</script>';
   
  // }
  // else{  echo'<script>alert("Kode Order Yang Anda Masukkan Salah");window.location ="konfirmasi.php";</script>';
 // }
}
}

?>
<?php
echo'
<div id="keranjang">
<h2 align="center">Konfirmasi Pembayaran</h2>
<form method="post" enctype="multipart/form-data" onsubmit="return validasi_input(this)">
<table>
<tr><td>&raquo;&nbsp;Kode Order *</td><td></td><td><input  name="kode_order" size="18" onKeyPress="return HanyaAngka(event)" class="texbox" maxlength="25" value="'.$_POST['kode_order'].'"><br>'.$err['kode_order'].' </td></tr>
<tr><td>&raquo;&nbsp;Tanggal Transfer * </td><td></td><td><input name="tanggal" size="25" class="texbox" value="'.$_POST['tanggal'].'"><span class="err2">[ Format yyyy-mm-dd ]</span><br>'.$err['tanggal'].'</td></tr>
<tr><td>&raquo;&nbsp;Pemilik Rekening * </td><td></td><td><input name="nama_pemilik" size="50" class="texbox" value="'.$_POST['nama_pemilik'].'"><br>'.$err['nama_pemilik'].'</td></tr>
<tr><td>&raquo;&nbsp;Nama Bank * </td><td></td><td>

<select name="nama_bank"  class="texbox" value="'.$_POST['nama_bank'].'">
<option value="pilih">-- PILIH --</option>'.$err['nama_bank'].'
<option value="BCA">BCA</option>
<option value="MANDIRI">MANDIRI</option>
<option value="BRI">BRI</option>
<option value="BNI">BNI</option>
</select>'.$err['nama_bank'].'
</td>


</tr>

<tr><td>&raquo;&nbsp;Jumlah Transfer * </td><td> Rp.</td><td>
<input name="jumlah_transfer" size="15" onKeyPress="return HanyaAngka(event)" class="texbox" maxlength="12" value="'.$_POST['jumlah_transfer'].'"><br>'.$err['jumlah_transfer'].'</td></tr>
<tr><td>&raquo;&nbsp;Alamat Pengiriman *</td><td></td><td>
<textarea class="texarea" name="alamat" cols="50" rows="7" value="'.$_POST['alamat'].'"></textarea><br>'.$err['alamat'].'<span class="err2">[ex: jl.xxxx N0.xx kec.xxx Kode Pos, Kota]</span></td></tr>
<tr><td>&raquo;&nbsp;Bukti/Gambar *</td><td></td><td><input type="file" name="gambar" value="'.$_FILES['gambar'].'">'.$err['gambar'].'</td></tr>
<center>
<tr><td>&raquo;&nbsp;Kode * </td><td></td><td><img src="captcha.php?rand=" id="captchaimg" style="float:left;margin:6px 4px 0 0;border:1px dashed #000;">
        <small style="float:left">kode ini susah?</br><a href=\'javascript: refreshCaptcha();\'>Coba</a> Kede Lain</small>
        <script language="JavaScript" type="text/javascript">
        function refreshCaptcha(){
            var img = document.images[\'captchaimg\'];
            img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
            }
        </script><div class="cleared"></div><input id="sixletterscode" name="sixletterscode" type="text"  maxlength="6"
        class="texarea" style="width:190px;height:60px;font-family:FontCaptcha;font-size:44px;color:#000;text-align:center;">
        <br>'.$err['sixletterscode'].' </td></tr></center>


 <div class="cleared"></div>


    <tr><td><input type="hidden" name="act" value="add">
    <input type="submit" value="Kirim" class="btn">
    </td></tr>


</table>
<p>&raquo;Field yang pake tanda (*) tidak boleh kosong !!</p>

</div>';

?>
<?php

echo '&nbsp;<div class="cleared"></div>';

// *** LOAD PAGE FOOTER
include "footer.php";

?>
