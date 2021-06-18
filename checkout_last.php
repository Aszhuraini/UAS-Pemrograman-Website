
<?php
// *** LOAD PAGE HEADER
include "header.php";
include"sidebar.php";
?>

<div id="keranjang2">
<div id="hightlight2"><i class="fa fa-exchange"></i> Detail Belanja & Pengiriman Barang</div>


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

//function getLastTrans() { $querycount="SELECT MAX(kode_order) AS LastID FROM daftar_pesanan";
//$result=mysql_query($querycount) or die(mysql_error());
//$row=mysql_fetch_array($result, MYSQL_ASSOC); return $row['LastID']; }
//function FormatNoTrans($num) { $num=$num+1;
 //switch (strlen($num)) {
 //   case 1 : $NoTrans = "0000".$num; break;
  //  case 2 : $NoTrans = "000".$num; break;
   // case 3 : $NoTrans = "00".$num; break;
    //case 4 : $NoTrans = "0".$num; break;
      // default: $NoTrans = $num; }
       //        return $NoTrans; }

//$LastID=FormatNoTrans(getLastTrans());
$LastID=date("Ymd").date("his");

//unset ($err);
$status="NEW";
if ($_POST['act']=="order"){


     //$kode= '/^[a-z]/';
    if (empty($_POST['info_belanja'])) $err['info_belanja']="<span class=\"err\">Your Cart still empty.</span>\n";
    if (empty($_POST['namalengkap'])) $err['namalengkap']="<span class=\"err\">Silahkan Isi Nama Anda</span>\n";
    if (empty($_POST['email'])) $err['email']="<span class=\"err\">Silahkan lengkapi Email Anda.</span>\n";
    if (!preg_match("/^[a-z0-9\_\.\-]+\@[a-z0-9\_\.\-]+$/i",$_POST['email'])) $err['email']="<span class=\"err\">Email &quot;".$_POST['email']."&quot; Anda Tidak valid.</span>\n";
    if (empty($_POST['telphp'])) $err['telphp']="<span class=\"err\">Silahkan lengkapi No telepon Anda.</span>\n";
    //if (!preg_match("[".$kode."]",$_POST['telphp'])) $err['telphp']="<span class=\"err\">No  Telepon &quot;".$_POST['telphp']."&quot; Anda Tidak valid.</span>\n";
    if (empty($_POST['alamat'])) $err['alamat']="<span class=\"err\">Silahkan Lengkapi Alamat Anda.</span>\n";
    if ($_POST['sixletterscode']<>$_SESSION['6_letters_code']) $err['sixletterscode']="<span class=\"err\">Validasi Yang Anda Masukkan Salah.</span>\n";
    if(count($err)>0){ // *** if submit error
        echo "<div id='notif'>Data Yang Anda Masukkan Masih Ada Yang Salah, Silahkan Perbaiki, Terima Kasih</div>";
    } else { // *** if submit OK
        $mode="order_send_ok";
        // *** WRITE DATABASE
        $sql_insert="INSERT INTO daftar_order (kode_order,tanggal_order,jam_order,orders_info,status) "
        ."VALUES ('".$_POST['kode_order']."','".date("Y-m-d")."','".date("h:i:s")."','".$_POST['info_belanja']."','".$_POST['status']."')";
        @mysqli_query($GLOBALS["___mysqli_ston"], $sql_insert);

        $sql_insert2="INSERT INTO pembeli(kode_order,nama_pembeli,email_pembeli,telepon_pembeli,alamat_pembeli) "
        ."VALUES ('".$_POST['kode_order']."','".$_POST['namalengkap']."','".$_POST['email']."','".$_POST['telphp']."', "
        ."'".$_POST['alamat']."')";
        @mysqli_query($GLOBALS["___mysqli_ston"], $sql_insert2);


    //$sql_edit="UPDATE produk SET
    //"."stok= '".$stok."' - '".$_POST['jumbel']."' "."WHERE id_produk='".$product_id."' ";
  // @mysql_query($sql_edit);

        /* MENGIRIM EMAIL ORDERAN */
        $to      = $_POST['email'];
        $subject = 'Info Belanja';
        $message='Yang Terhormat Saudara '.$_POST['namalengkap'].'
                  Kode Order Anda adalah '.$_POST['kode_order'].'
                  Silahkan Disimpan untuk keperluan konfirmasi pembayaran

                 ';
        $print = 'Yang Terhormat Saudara <h1>'.$_POST['namalengkap'].'</h1><br>
        Orderan Anda Sudah Masuk Kedalam Database Kami<br>
        Dengan Detail seperti berikut : <br> <br>

        Kode Order Anda adalah <b>'.$_POST['kode_order'].'</b> Silahkan Dicatat Untuk Kelengkapan bukti pembelian<br><br>
        kode order ini juga sudah kami kirim ke email anda, silahkan dicek inbox atau spam email anda<br>



      <div id="info"> '.$_POST['info_belanja'].'</div>

        <br>
        <br>
         <br>

       Dan Akan Segera kami proses 1x24 Jam Setelah Anda Melakukan Pembayaran ke ATM kami di dibawah ini <br><br>
        <center><img src="images/mandiri.png" width="300px" height="100px"><br>
         <h4>Mandiri 00000000000<br>
         TOKOKU</h4><br>
         </center><br>
        Dan  mengririmkan Bukti pembayaran yang sah ke Customer Service  kami,</br>
        Untuk bukti yang dikirimkan berupa screenshot kertas bukti pembayaran yang diperoleh dari mesin ATM, serta kode order yang didapatkan</br>
        Atau screenshot bukti pembayaran lain yang anda gunakan seperti, m-banking, e-banking dan lain sebagainya,</br>
        <br>
        Untuk Konfirmasi pembayaran, Silahkan Klik Link Dibawah ini <br><br>
        <a href="konfirmasi.php">Konftimasi Pembayaran</a><br><br>

        Atau Jika Anda Ingin Konfirmasi nanti, Silahkan Lihat Di menu yang sudah disediakan di web kami,,<br>
        Terima Kasih<br>
        Salam Hormat kami<br><br><be>


        <h1>TOKOKU</h1>
        <br><br>';


        $headers = 'From: info@tokoku.com' . "\r\n" .
            'Reply-To: info@tokoku.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        @mail($to, $subject, $message, $headers);

        /* MENGIRIM EMAIL NOTIIFIKASI ORDERAN MASUK */
        $to2      = "info@tokoku.com";
        $subject = 'Orderan TOKOKU.com';
        $message = 'Orderan Baru dari '.$_POST['namalengkap'].'
        Dengan Kode Order : '.$_POST['kode_order'].'
        ';
        $headers2 = 'From: '.$_POST['email'] . "\r\n" .
            'Reply-To: ' .$_POST['email']. "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        @mail($to2, $subject, $message, $headers2);

        unset ($_SESSION['cart']);
        echo 'Yang Terhormat Saudara <h1>'.$_POST['namalengkap'].'</h1>

        <p>Kode Order Anda adalah <b>'.$_POST['kode_order'].'</b> Silahkan Dicatat Untuk Kelengkapan bukti pembelian</p>
        <p>atau bisa melihat inbox atau spam email anda, karena kode order ini juga sudah kami kirimkan ke email anda</p>
        <p>Orderan Anda Sudah Masuk Kedalam Database Kami</p>
        Dengan Detail seperti berikut : <br> <br>


      <div id="info"> '.$_POST['info_belanja'].'</div>

      <div class="cleared"></div>

         <p>Total harga tersebut belum termasuk ongkos kirim, oleh karena itu kami sarankan agar tidak melakukan transfer dulu
         sebelum customer service kami menghubungi anda untuk kelengkapan pembayaran selengkapnya,
         dan setelah anda mendapat konfirmasi total yang harus dibayar [Total belanjaan + Ongkos Kirim] dari cust service kami maka

        anda sudah bisa melakukan pembayaran kepada kami melalui rekening dibawah ini</p>
        <center><img src="images/mandiri.png" width="300px" height="200px"><br>
        <h4>Mandiri 00000000000<br>
        T</h4><br>
         </center></p><br>
        <p>Orderan anda Akan Segera kami proses 1x24 Jam Setelah Anda Melakukan Pembayaran ke ATM kami dan  mengririmkan Bukti pembayaran yang sah ke Customer Service baik melalui sms, BBM atau melalui form yang sudah kami sediakan diwebsite kami, dan Untuk bukti yang dikirimkan adalah berupa screenshot kertas bukti pembayaran yang  diperoleh dari mesin ATM, Atau screenshot bukti pembayaran lain yang anda gunakan seperti, m-banking, e-banking dan lain sebagainya,</p>





        Terima Kasih<br>
        Salam Hormat kami<br><br><br>


        <h1>TOKOKU</h1><br>

        <br><br>';


    }
}



if ($mode!="order_send_ok"){ // *** DISPLAY FORM IF NO ORDERS TO BE SENT

$no=0;
$checkout_cnt="";

// JIKA KERANJANG TIDAK KOSONG
if($_SESSION['cart']) {
    // TAMPILKAN TABEL KERANJANG

    $checkout_cnt.= "<table  cellspacing=0 cellpadding=0 id=\"checkout_last\">";	// format tampilan menggunakan HTML table
     $checkout_cnt.= "<tr><td><b>NO</td>
                     <td><b>Kode Barang</td>
                     <td><b>Nama </td>

                     <td><b>Harga</b></td>
                     <td><b>Jumlah Beli</b></td>
                     <td><b>Subtotal</b></td>

                     </tr>";
        // LOOPING / PENGULANGAN : UNTUK MENDEFINISIKAN ISI KERANJANG
        // $product_id sebagai key DAN $quantity sebagai value
        foreach($_SESSION['cart'] as $product_id => $quantity) {
             $gambar ="<a href=\"items/".$product_id.".jpg\">
        <img src=\"items/".$product_id.".jpg\" width=80 height=80 align=center border=1px </a>";
               //$ukuran='<select name="ukuran">
              // <option>L</option>
               // <option>L</option>
                // <option>L</option>';
                //if (!empty($_POST['ukuran']))$_SESSION['sukuran']=$_POST['ukuran'];
                //if ($_SESSION['sukuran']==$_POST['ukuran']) echo "selected";


            // MENDAPATKAN name, description, price DARI database - INI TERGANTUNG penamaan implementation database anda .
            // GUNAKAN FUNCTION sprintf AGAR/SUPAYA $product_id MASUK KE DALAM query SEBAGAI SEBUAH number - UNTUK MENGHINDARI SQL injection (HACKING)
            $sql = sprintf("SELECT id_produk, nama_produk, deskripsi, harga FROM produk WHERE id_produk = %d;",
                            $product_id);

               $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);

            // HANYA MENAMPILKAN JIKA PRODUCT NYA ADA / TIDAK KOSONG
            if(mysqli_num_rows($result) > 0) {
                $no++;

                list($kode, $name, $description, $price,$stok) = mysqli_fetch_row($result);


                // MENGHITUNG SUBTOTAL ($line_cost) DARI HARGA ($price) * JUMLAH ($quantity)
                $line_cost = $price * $quantity;

                // MENGHITUNG TOTAL JUMLAH ($quantity)
                 $total_quantity += $quantity;





                // MENGHITUNG TOTAL DENGAN MENAMBAHKAN SUBTOTAL ($line_cost) MASING2 PRODUCT
                //$total = $total + $line_cost;
                $totalx += $line_cost;


                $checkout_cnt.="<tr>";
                    // MENAMPILKAN DATA KE DALAM table cells
                    $checkout_cnt.="<td>$no.</td><td>BR$kode</td><td>$name</td>";
                    $checkout_cnt.="<td>".format_currency($price)."</td>";
                    //$checkout_cnt.="<td>".$ukuran."</td>";
                    $checkout_cnt.="<td>".$quantity."[Items]</td>";
                    $checkout_cnt.="<td>".format_currency($line_cost)."</td>";

                    $info_belanja.="$kode | $name | $price | $quantity | $line_cost \n";

                $checkout_cnt.="</tr>";

            }

        }

        //show the total
        $checkout_cnt.="<tr>";
            $checkout_cnt.="<td colspan=\"5\"  class=\"num\">TOTAL BAYAR</td>";
            $checkout_cnt.="<td>".format_currency($totalx)."</td>";
        $checkout_cnt.="</tr>";
                    $info_belanja.="TOTAL=  $total\n";



    $checkout_cnt.="</table><br>";

    echo $checkout_cnt;
echo'



    <form method="post">
    <input type="hidden" name="info_belanja" value="'.htmlentities($checkout_cnt).'">
    <table id="kirim">
    <tr><td>&raquo; No Sales Order* &nbsp;&nbsp; </td><td class="cv"><input name="kode_order" size="40" class="texbox" value= '.$LastID.'  readonly></td></tr>
    <tr><td>&raquo; Nama Lengkap*  </td><td class="cv"><input name="namalengkap" size="40"  class="texbox"  value="'.$_POST['namalengkap'].'"><br>'.$err['namalengkap'].'</td></tr>
    <tr><td>&raquo; Email*  </td><td class="cv"><input name="email" class="texbox" size="40"   value="'.$_POST['email'].'"><br>'.$err['email'].'</td></tr>
    <tr><td>&raquo; No. Handphone*  &nbsp;</td><td class="cv"><input name="telphp" size="40" maxlength="12" onKeyPress="return HanyaAngka(event)" class="texbox" value="'.$_POST['telphp'].'"><br>'.$err['telphp'].'</td></tr>
    <tr><td>&raquo; Alamat Rumah* </td><td class="cv"><textarea name="alamat" rows=4 cols=50 class="texarea">'.$_POST['alamat'].'</textarea><br>'.$err['alamat'].'</td></tr>
     <input type="hidden" name="status" value="'.($status).'">
    <tr><td></td><td class="cv">

        </script>
        <div>';

echo'

    <tr><td></td><td><input type="hidden" name="act" value="order">
    <input type="submit" value="Kirim" class="btn"></td></tr>
    <tr><td></td><td>&raquo;Field yang pake tanda (*) tidak boleh kosong !!</td></tr>


    </table>



    ';

}

else{
    //tampilan jika keranjang kosong
echo'
  <marquee>Keranjang Anda Masih Kosong,Silahkan berbelanja terlebih dahulu</marquee>
  <hr>
  ';

//include"else_checkout.php";
}


}// *** END if ($mode!="order_send_ok") // *** DISPLAY FORM IF NO ORDERS TO BE SENT
?>
</div>

<?php

echo '&nbsp;<div class="cleared"></div>';

// *** LOAD PAGE FOOTER
include "footer.php";

?>
