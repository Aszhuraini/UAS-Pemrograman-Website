
<?php
// *** SWITCH ACTION
'echo<div id="tbcart">';
$conn = ($GLOBALS["___mysqli_ston"] = mysqli_connect("localhost", "root", "")) or die("can not access database");
mysqli_select_db($conn, phpshop) or die("can not connect");

$product_id = $_GET[id];	 //the product id from the URL
$action 	= $_GET[action]; //the action from the URL


switch($action) {

    case "add":
        // TAMBAH 1 UNTUK NILAI PRODUCT ID -> $product_id
        $_SESSION['cart'][$product_id]++;
    break;

    case "remove":
        // KURANG 1 UNTUK NILAI PRODUCT ID -> $product_id
        $_SESSION['cart'][$product_id]--;
        // JIKA SETELAH DIKURANGI NILAI == 0, VARIABLE SESSION PRODUCT ID -> $product_id DI HAPUS DENGAN fucntion "unset"
        // Karena jika tidak di- "unset" nilai nya menjadi -1 , -2, dst ketika user terus mengurangi item cart
        if($_SESSION['cart'][$product_id] == 0) unset($_SESSION['cart'][$product_id]);
    break;

    case "empty":
        // MENGKOSONGKAN CART (KERANJANG) memakai function unset SELURUH ITEM PRODUCT AKAN DIKOSONGKAN
        unset($_SESSION['cart']);
    break;

}



if($_SESSION['cart']) {	// *** JIKA KERANJANG ADA ISI NYA / TIDAK KOSONG


    // TAMPILKAN TABEL KERANJANG
    echo "<table border=\"0\"  cellspacing=0 cellpadding=0 id=\"tbcart\">";	// format tampilan menggunakan HTML table
    echo '<tr><td colspan=4><h1>Cart</h1></td></tr>';


        // LOOPING / PENGULANGAN : UNTUK MENDEFINISIKAN ISI KERANJANG
        // $product_id sebagai key DAN $quantity sebagai value
        foreach($_SESSION['cart'] as $product_id => $quantity) {

            // MENDAPATKAN name, description, price DARI database - INI TERGANTUNG penamaan implementation database anda .
            // GUNAKAN FUNCTION sprintf AGAR/SUPAYA $product_id MASUK KE DALAM query SEBAGAI SEBUAH number - UNTUK MENGHINDARI SQL injection (HACKING)
            $sql = sprintf("SELECT name, description, price FROM php_shop_products WHERE id = %d;",
                            $product_id);

            $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);

            // HANYA MENAMPILKAN JIKA PRODUCT NYA ADA / TIDAK KOSONG
            if(mysqli_num_rows($result) > 0) {

                list($name, $description, $price) = mysqli_fetch_row($result);

                // MENGHITUNG SUBTOTAL ($line_cost) DARI HARGA ($price) * JUMLAH ($quantity)
                $line_cost = $price * $quantity;

                // MENGHITUNG TOTAL DENGAN MENAMBAHKAN SUBTOTAL ($line_cost) MASING2 PRODUCT
                $total_cost += $line_cost;
                $total_quantity += $quantity;

                echo "<tr>";
                    // MENAMPILKAN DATA KE DALAMN table cells
                    echo "<td>$name</td>";
                    echo "<td>".format_currency($price)."</td>";
                    // PENULISAN 'remove' link DI SEBELAH quantity - LINK KE HALAMAN INI,
                    // TAPI ACTION NYA remove DARI id PRODUCT YANG DIPILIH
                    echo "<td nowrap>$quantity</br>"
                    ."<a href=\"$_SERVER[PHP_SELF]?action=remove&id=$product_id\" class=\"mybtn\"><span>-</span> Cart</a></td>";
                    echo "<td nowrap>".format_currency($line_cost)."</td>";

                echo "</tr>";

            }

        }

        //TAMPILKAN TOTAL
        echo "<tr>";
            echo "<td colspan=\"2\" class=\"tdtotal\">TOTAL</td>";
            echo "<td class=\"tdtotal\">".number_format($total_quantity,0,"",".")."</td>";
            echo "<td nowrap class=\"tdtotal\">".format_currency($total_cost)."</td>";
        echo "</tr>";

        // LINK empty cart - YANG MANA LINK KE HALAMAN INI JUGA, TAPI DENGAN action = empty.
        // SERTA javascript KETIKA onlick event MENANYAKAN user UNTUK KONFIRMASI
        echo "<tr>";
            echo "<td colspan=\"4\">"
            ."<a href=\"$_SERVER[PHP_SELF]?action=empty\" class=\"mybtn\" onclick=\"return confirm('Are you sure?');\">Empty Cart</a> \n"
            .'<a href="checkout.php" class="mybtn">Checkout</a>'
            ."</td>";
        echo "</tr>";
    echo "</table>";

}


else
{  // JIKA KERANJANG KOSONG -> TAMPILKAN PESAN INI

    echo "<table border=\"0\" cellspacing=0 cellpadding=0 id=\"tbcart\">";	// format tampilan menggunakan HTML table
    echo "<tr><td><h1>Cart</h1><blink>Keranjang Anda Masih Kosong</blink></td></tr>";
    echo "</table>\n";
}

?>
