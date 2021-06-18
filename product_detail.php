<?php
session_start(); 
echo '<h1>Products Detail</h1>';

include "db_conn.php";


// QUERY TABLE php_shop_products

		$sql = "SELECT id, name, description, price FROM php_shop_products WHERE id='".$_GET['id']."';";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        $row = mysqli_fetch_array($result);
		
			if (file_exists("items/".$row['id'].".jpg"))
                $gambar="<img src=\"items/".$row['id'].".jpg\" width=500>";
            else
                $gambar="";

				echo "<h2 style=\"background:#ffcccc; border-radius:20px; padding:6px\">".$row['name']."</h2>";
				echo "<div style=\"background:#ccffcc; border-radius:20px; padding:6px\">".$row['description']."</p>"
                ."</br>".$gambar;
				echo "<p>Harga ".$row['price']."</p>";
				echo "<p>"
                ."<a href=\"products_n_cart.php\">Product List</a> &nbsp;  |  &nbsp; "
                ."<a href=\"$_SERVER[PHP_SELF]?action=add&id=".$row['id']."\">[+] Add To Cart</a>"
                ."</div>";
			




echo '<h1>Cart</h1>';

// KONEKSI DATABASE
$conn = ($GLOBALS["___mysqli_ston"] = mysqli_connect("localhost", "root", "bunda123")) or die("can not access database");
mysqli_select_db($conn, phpshop) or die("can not connect");

$product_id = $_GET[id];	 //the product id from the URL 
$action 	= $_GET[action]; //the action from the URL 


switch($action) {	// SWITCH ACTION

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
    echo "<table border=\"1\" >";	// format tampilan menggunakan HTML table
    
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
                $total = $total + $line_cost;			
            
                echo "<tr>";
                    // MENAMPILKAN DATA KE DALAMN table cells
                    echo "<td align=\"center\">$name</td>";
                    echo "<td align=\"center\">$price</td>";
                    // PENULISAN 'remove' link DI SEBELAH quantity - LINK KE HALAMAN INI, 
                    // TAPI ACTION NYA remove DARI id PRODUCT YANG DIPILIH
                    echo "<td align=\"center\">$quantity "
                    ."<a href=\"$_SERVER[PHP_SELF]?action=remove&id=$product_id\">[-]</a></td>";
                    echo "<td align=\"center\">$line_cost</td>";
                
                echo "</tr>";
                
            }
        
        }
        
        //TAMPILKAN TOTAL
        echo "<tr>";
            echo "<td colspan=\"3\" align=\"right\">Total</td>";
            echo "<td align=\"right\">$total</td>";
        echo "</tr>";
        
        // LINK empty cart - YANG MANA LINK KE HALAMAN INI JUGA, TAPI DENGAN action = empty. 
        // SERTA javascript KETIKA onlick event MENANYAKAN user UNTUK KONFIRMASI 
        echo "<tr>";
            echo "<td colspan=\"4\" align=\"right\">"
            ."<a href=\"$_SERVER[PHP_SELF]?action=empty\" onclick=\"return confirm('Are you sure?');\">Empty Cart</a>"
            ."</td>";
        echo "</tr>";		
    echo "</table>";
    
    // *** LINK CHECKOUT
    echo '<a href="checkout.php">checkout</a>';
    

}
else
{  // JIKA KERANJANG KOSONG -> TAMPILKAN PESAN INI

    echo "You have no items in your shopping cart.";
    
}



?>