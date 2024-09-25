<?php
include 'connection.php';

$op = $_POST['op'];
$product = $_POST['product'];
$user_id = $_SESSION['user_id'];

if($op=='add'){
    $addCart = "INSERT INTO `cart` (`cart_id`, `product_id`, `user_id`, `quantity`) VALUES (NULL, '$product', '$user_id', '1');";
    $addCartResult = $mysqli->query($addCart);
    $_SESSION['cart']='on';
}
else if($op=='remove'){
    $removeCart = "DELETE FROM cart WHERE `product_id` = '$product' AND `user_id` = '$user_id';";
    $removeCartResult = $mysqli->query($removeCart);
    $_SESSION['cart']='on';
}
else if($op=='removeCart'){
    $removeCart2 = "DELETE FROM cart WHERE `product_id` = '$product' AND `user_id` = '$user_id';";
    $removeCartResult2 = $mysqli->query($removeCart2);
}
else if($op=='change'){
    $quantity = $_POST['quantity'];
    $quantityCart = "UPDATE `cart` SET `quantity`='$quantity' WHERE `product_id` = '$product' AND `user_id` = '$user_id';";
    $quantityCartResult = $mysqli->query($quantityCart);
}
$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>