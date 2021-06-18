<?php
// KONEKSI DATABASE
$conn = ($GLOBALS["___mysqli_ston"] = mysqli_connect($db_host, $db_user, $db_pass));
mysqli_select_db($conn, $db_name);
?>