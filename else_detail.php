<?php

    // *** DISPLAY TABLE PRODUCTS
echo '

     <div id=bgproduct>';
// QUERY TABLE php_shop_products n record per page
$sql = "SELECT * FROM php_shop_products  WHERE category LIKE '%".$_GET['id_barang']."'%";

//echo $sql;
$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
$ada = @mysqli_num_rows($result);


    while ($row = mysqli_fetch_array($result))
        {

echo'

               <div class="barang">';

                echo'
                <table>';
                echo'
                <tr>
                <td class="nama">';
                echo"".$row['name']."";
                echo'
                </td>
                </tr>';

                echo'
                <tr>
                <td>';
                echo"".$gambar."<a href=\"items/".$row['id'].".jpg\"><img src=\"items/".$row['id'].".jpg\" width=186 height=160 align=center border=1px </a>";
                echo'
                </td>
                </tr>';



                echo'
                <tr>
                <td>';
                 echo"Price: ".format_currency($row['price'])."";
                echo'
                </td>
                </tr>';

                 echo'
                <tr>
                <td>';
                echo "<a href=\"$_SERVER[PHP_SELF]?action=add&id=".$row['id']."\" class=\"tbeli\"><span><img src='images/beli.png' class='tbeli'></span></a>";
                 echo "<a href=\"detail.php?id_barang=".$row['id']."\" class=\"tbeli\"><span><img src='images/detail.png' class='tbeli'></span></a>";

                echo'
                </td>
                </tr>';


             echo'
             </table>';
             echo'
             </div>';
}
echo '
    </div>
    ';



?>
