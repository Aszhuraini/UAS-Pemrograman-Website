<?php
function writeShoppingCart() {
    $carts = $_SESSION['cart'];
    if (!$carts) {
        return '<p>You have no items in your shopping cart</p>';
    } else {
        $s = (count($carts) > 1) ? 's':'';
        return '<p>You have <a href="cart.php">'.count($carts).' item'.$s.' in your shopping cart</a></p>';
    }
}
?>
