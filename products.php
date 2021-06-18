<?php
echo '<h1>Products</h1>';

// KONEKSI DATABASE
$conn = ($GLOBALS["___mysqli_ston"] = mysqli_connect("localhost", "root", "")) or die("can not access database");
mysqli_select_db($conn, phpshop) or die("can not connect");

echo '
<table border="1">
';

// QUERY TABLE php_shop_products
		$sql = "SELECT id, name, description, price FROM php_shop_products;";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        while ($row = mysqli_fetch_array($result)){
		
			echo "<tr>";
			
				echo "<td>".$row['name']."</td>";
				echo "<td>".$row['description']."</td>";
				echo "<td>".$row['price']."</td>";
				echo "<td><a href=\"cart.php?action=add&id=".$row['id']."\">[+] Add To Cart</a></td>";
			
			echo "</tr>";
		}
		
echo'
</table>
';

echo '<a href="cart.php">View Cart</a>';
?>
