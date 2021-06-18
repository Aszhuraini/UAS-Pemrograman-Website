<?php
// *** LOAD PAGE HEADER
include "header.php";


$sql="SELECT * FROM pages WHERE id='". $_GET['id'] ."'";
$qry=@mysqli_query($GLOBALS["___mysqli_ston"], $sql);
$pecah = @mysqli_fetch_array($qry);

echo '<div style="text-align:left">';
echo '<h1>'. $pecah['judul']  .'</h1>';

echo $pecah['isi'];

echo '</div>';





include "footer.php";
?>
