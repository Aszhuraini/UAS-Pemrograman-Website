<?php
// *** MENGHAPUS SESSION SEARCH / RESETING
if ($_POST['clear']=="y"){ unset($_SESSION['scari']); unset($_SESSION['scategory']);
unset($_POST['cari']); unset($_POST['category']);}
if ($_GET['clear']=="y"){ unset($_SESSION['scari']); unset($_SESSION['scategory']);
}

// ***  DEKLARASI VARIABLE
if (!empty($_GET['page'])) $_SESSION['page']=$_GET['page'];
if (!empty($_SESSION['page'])) $_GET['page']=$_SESSION['page'];
if (!empty($_POST['category'])) $_SESSION['scategory']=$_POST['category'];
if (!empty($_POST['cari'])) $_SESSION['scari']=$_POST['cari'];


// *** DEFAULT VARIABLE SETTING
$line_cost=0; // *** CART - SUBTOTAL COST
$total_cost=0; // *** CART - TOTAL COST
$line_quantity=0; // *** CART - SUBTOTAL QUANTITY
$total_quantity=0; // *** CART - TOTAL QUANTITY

// *** QUERY SEARCH
$qry_0 = "SELECT id FROM php_shop_products ";
$qry_t="WHERE  category LIKE '%".$_SESSION['scategory']."%' AND ";
$qry_t.="( name LIKE '%".$_SESSION['scari']."%' ";
$qry_t.="OR category LIKE '%".$_SESSION['scari']."%' ";
$qry_t.="OR description LIKE '%".$_SESSION['scari']."%') ";

//echo "[ $qry_0.$qry_t ]";
$total_rec=@mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], $qry_0.$qry_t)); // *** TOTAL RECORD PRODUCT

$rowperpage=4; // *** DISPLAY NUM RECORD PER PAGE

// ** predefine record number
if (!empty($_GET['page'])) $recno=($_GET['page']-1)*$rowperpage; else $recno=0;



if ($ada>0){ // ** IF RECORD EXISTS

    // ** PAGING NAVIGATION
    if ($total_rec>$rowperpage){ // *** IF TOTAL RECORD GREATER THAN RECORD PER PAGE => SHOW PAGING
    $paging_html.= '<div id="paging">';
    if (empty($_GET['page'])) $_GET['page']=1; // ** SET DEFAULT PAGE = 1
    // *** PREV RECORD LINK
    if ($_GET['page']>1) $paging_html.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($_GET['page']-1).'"><id="back">&laquo;Back</a>';
    // *** PAGING NUMBERS LINK
    for ($i=1; $i<= ceil($total_rec/$rowperpage); $i++){
        $paging_html.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'"';
        if ($_GET['page']==$i) $paging_html.= ' id="paging_cur" ';
        $paging_html.= '>'.$i.'</a>';
    }
    // *** NEXT RECORD LINK
    if ($_GET['page']<ceil($total_rec/$rowperpage)) $paging_html.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($_GET['page']+1).'">&raquo;Next</a> ';
    $paging_html.= '</div><!-- id="paging" -->';
    } // *** end if ($total_rec>$rowperpage)

}




// QUERY TABLE php_shop_products n record
$sql = "SELECT id,category, name, description, price FROM php_shop_products ".$qry_t." ORDER BY id ;";

//echo $sql;
$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
$ada = @mysqli_num_rows($result);

    // *** DISPLAY TABLE PRODUCTS
    echo '


     <h1 align="center">List Product</h1><hr>'.$paging_html.'

    ';

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
                echo"".$gambar."<a href=\"items/".$row['id'].".jpg\"><img src=\"items/".$row['id'].".jpg\" width=186 height=150 align=center border=1px </a>";
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
                 echo "<a href=\"$_SERVER[PHP_SELF]?action=add&id=".$row['id']."\" class=\"tbeli\"><span><img src='images/cart.png' class='tbeli'>Add to Cart</span></a>";
                 echo "<a href=\"detail.php?id_barang=".$row['id']."\" class=\"tbeli\"><span>Detail</span></a>";


                echo'
                </td>
                </tr>';


             echo'
             </table>';
             echo'
             </div>';
}

?>
