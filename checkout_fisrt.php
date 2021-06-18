<?php
// *** LOAD PAGE HEADER
include "header.php";
include"sidebar.php";
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
<div id="keranjang">
<div id="hightlight2"><i class="fa fa-exchange"></i> Detail Belanja</div>
<br>

<?php

// JIKA KERANJANG TIDAK KOSONG
if($_SESSION['cart']) {
    // TAMPILKAN TABEL KERANJANG

    $checkout_cnt.= "<table   cellspacing=0 cellpadding=0 id=\"checkout_fisrt\">";	// format tampilan menggunakan HTML table
    $checkout_cnt.= "<tr>
                    <td><b>No</b></td>
                    <td><b>Kode Barang</td>
                     <td><b>Nama Barang</td>
                     <td><b>Gambar</b></td>
                     <td><b>Harga</b></td>
                     <td><b>Jumlah Beli</b></td>
                     <td><b>Subtotal</b></td>
                     <td colspan='2'><b>Pilihan</b></td>

                     </tr>";

       // LOOPING / PENGULANGAN : UNTUK MENDEFINISIKAN ISI KERANJANG
        // $product_id sebagai key DAN $quantity sebagai value
        
        foreach($_SESSION['cart'] as $product_id => $quantity) {
            $gambar ="<a href=\"items/".$product_id.".jpg\">
        <img src=\"items/".$product_id.".jpg\" width=80 height=90 align=center border=1px </a>";





            // MENDAPATKAN name, description, price DARI database - INI TERGANTUNG penamaan implementation database anda .
            // GUNAKAN FUNCTION sprintf AGAR/SUPAYA $product_id MASUK KE DALAM query SEBAGAI SEBUAH number - UNTUK MENGHINDARI SQL injection (HACKING)
            $sql = sprintf("SELECT id_produk, nama_produk, deskripsi, harga, stok FROM produk WHERE id_produk = %d;",
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

                  $sql2= sprintf("SELECT * FROM ukuran ");
                  $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql2);
	              while($row=mysqli_fetch_array($result)) {
               $ukuran=$row['nama'];

                 }

                // MENGHITUNG TOTAL DENGAN MENAMBAHKAN SUBTOTAL ($line_cost) MASING2 PRODUCT
                //$total = $total + $line_cost;
                $totalx += $line_cost;



                   $checkout_cnt.="<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."?id=$product_id\"><tr>";
                    // MENAMPILKAN DATA KE DALAM table cells
                    $checkout_cnt.="<td>$no.</td><td>BR$kode</td><td>$name</td>";


                    $checkout_cnt.="<td>".$gambar."</td>";
                     // $checkout_cnt.="<td><select><option>".$ukuran."</option><select></td>";
                    $checkout_cnt.="<td >".format_currency($price)."</td>";

                    $checkout_cnt.="<td><input type='text' id='texbox' size='2' maxlength='3' onKeyPress='return HanyaAngka(event)' class=\"jumbel\" value='".$quantity."' name='jumbel' ></td>";
                    $checkout_cnt.="<td>".format_currency($line_cost)."</td>";
                     $checkout_cnt.="<td class=\"num\">"."<a href=\"$_SERVER[PHP_SELF]?action=remove&id=$product_id\"><input type='button' class='btnhps' value='X'></a></td>";
                    $checkout_cnt.="<td>"
                    ."<input alt=\"".$_SERVER['PHP_SELF']."?id=$product_id&action=update&jumbel=\" type='button' class=\"btupdate btn2\" value='Update' ></td>";

$checkout_cnt.=""."<a href=\"$_SERVER[PHP_SELF]?action=empty\" class=\"btnkrnjg\" onclick=\"return confirm('Yakin Akan dihapus?');\"><input type='button' value='Kosongkan Keranjang' class='btn3'></a>";


                    $info_belanja.="$name | $gambar | $price | $quantity | $line_cost \n";


            $checkout_cnt.="</tr>";

            }

        }

        //show the total
        $checkout_cnt.="<tr>";
        //$checkout_cnt.="<tr><td colspan=\"7\"  class=\"num\" align=\"center\">TOTAL ITEMS</td>";
       // $checkout_cnt.="<td>".$total_quantity."</td>";
         $checkout_cnt.="<tr><td colspan=\"8\"  class=\"num\" align=\"center\">&raquo;TOTAL BAYAR</td>";
        $checkout_cnt.="<td>".format_currency($totalx)."</td>";
        $checkout_cnt.="</tr>";
                    $info_belanja.="TOTAL=  $total\n";


     
    $checkout_cnt.="</table><br>";

    echo $checkout_cnt;
    ?>
    <script>
      $(".btupdate").click(function(){
            var newhref= $(this).attr('alt')+ $(this).parent().parent().find(".jumbel").val();

            window.location = newhref;
      });
    </script><br>
<a href="list_barang.php"><input type='button' value='Lanjutkan Belanja' class='btn3'></a>

<a href="checkout_last.php"><input type='button' value='Selesai Belanja' class='btn3' id='t_selesai'></a>
<?php
echo'

<p>Term & Condition</p>
<p>- Sebelum mengubah jumlah, silahkan lihat jumlah Stok yang tersedia, tidak boleh melewati stok yg ada.</p>
<p>- Apabila anda mengubah jumlah, setelah input data pada jumlah, tekan tombol Update.</p>
<p>- Total harga diatas belum termasuk ongkos kirim .<p><br>
';
?>
<?php
    }

else{
    //tampilan jika keranjang kosong
echo'<marquee>Keranjang Anda Masih Kosong,Silahkan berbelanja terlebih dahulu</marquee>';
}

?>

</div>

<?php

echo '&nbsp;<div class="cleared"></div>';

// *** LOAD PAGE FOOTER
include "footer.php";

?>
