<?php

$qry_0 = "SELECT id_produk FROM produk ";
$qry_t="WHERE  category LIKE '%".$_SESSION['scategory']."%' AND ";
$qry_t.="( nama_produk LIKE '%".$_SESSION['scari']."%' ";
$qry_t.="OR category LIKE '%".$_SESSION['scari']."%' ";
$qry_t.="OR deskripsi LIKE '%".$_SESSION['scari']."%') ";

//echo "[ $qry_0.$qry_t ]";
$total_rec=@mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], $qry_0.$qry_t)); // *** TOTAL RECORD PRODUCT

$rowperpage=3; // *** DISPLAY NUM RECORD PER PAGE

// ** predefine record number
if (!empty($_GET['page'])) $recno=($_GET['page']-1)*$rowperpage; else $recno=0;



$sql = "SELECT * FROM produk ".$qry_t." ORDER BY id_produk DESC LIMIT $recno,$rowperpage;";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);

$ada = @mysqli_num_rows($result);
$no=0;

if ($ada>0){ // ** IF RECORD EXISTS

    // ** PAGING NAVIGATION
    if ($total_rec>$rowperpage){ // *** IF TOTAL RECORD GREATER THAN RECORD PER PAGE => SHOW PAGING
    $paging_html.= '<div id="paging">';
    if (empty($_GET['page'])) $_GET['page']=1; // ** SET DEFAULT PAGE = 1
    // *** PREV RECORD LINK
    if ($_GET['page']>1) $paging_html.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($_GET['page']-1).'">&laquo;prev</a>';
    // *** PAGING NUMBERS LINK
    for ($i=1; $i<= ceil($total_rec/$rowperpage); $i++){
        $paging_html.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'"';
        if ($_GET['page']==$i) $paging_html.= ' class="paging_cur" ';
        $paging_html.= '>'.$i.'</a>';
    }
    // *** NEXT RECORD LINK
    if ($_GET['page']<ceil($total_rec/$rowperpage)) $paging_html.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($_GET['page']+1).'">next&raquo;</a> ';
    $paging_html.= '</div><!-- id="paging" -->';
    } // *** end if ($total_rec>$rowperpage)
    
    


    echo"<div id='p_terkait'>Produk Terkait  Kategori <b>&laquo; ".$_SESSION['scategory']." &raquo;</b></div>";
    echo"<div id='bgpaging2'>".$paging_html."</div>";
    while ($row = mysqli_fetch_array($result))
        {

        echo'<div class="barang">';
          echo'<table>';
          echo'<tr><td class="nama">';
          echo"".$row['nama_produk']."";
          echo'</td></tr>';

          echo'<tr><td>';
          echo"".$gambar."<a href=\"items/".$row['id_produk'].".jpg\">
          <img src=\"items/".$row['id_produk'].".jpg\" width=186 height=200 align=center border=1px </a>";
          echo'</td></tr>';

          echo'<tr><td>';
          echo"Price: ".format_currency($row['harga'])."";
          echo'</td></tr>';

          echo'<tr><td>';
          echo "<a href=\"$_SERVER[PHP_SELF]?action=add&id=".$row['id_produk']."\" class=\"tbeli\"><span>
          <img src='images/beli.png' class='tbeli'></span></a>";
          echo "<a href=\"detail.php?id_barang=".$row['id_produk']."\" class=\"tbeli\"><span>
          <img src='images/detail.png' class='tbeli'></span></a>";
          echo'</td></tr>';


          echo'</table>';
        echo'</div>';

}
}
?>
