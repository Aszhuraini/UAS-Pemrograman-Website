
<div id="left">
<div id="hightlight"><i class="fa fa-tasks"></i> Shop By Category</div>
<div class="kiri_kategori">
<?php
 //$idbarang = "SELECT id FROM php_shop_products WHERE id=".$_GET['id']"";
echo"<form method='post' action='list_barang.php'>";
$rcat=@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM categories");


while ($rowcat = @mysqli_fetch_array($rcat)) {

      echo"<div id='kategori'>";
         echo"<ul id=''>";
           echo "<li><i class='fa fa-check-square'></i>
           <a href=\"list_barang.php?category=".$rowcat['nama']."\">".$rowcat['nama']. " </a>";
           ?>

           <?php
           $idkat = "SELECT id categories";

           $jumlahkategori = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM produk WHERE id = $idkat"));
           ?> <?php echo"".$jumlahkategori.""?> </li>

<?php

         echo"</ul>";
       echo"</div>";
}
echo"</form>";
echo"</div>";
echo"<br>";
?>

</div>
