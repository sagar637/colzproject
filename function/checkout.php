<?php
include 'connection.php';

$_SESSION['payment'] = $_POST['payment-option'];
$_SESSION['address'] = $_POST['billing-address'];

if ($_SESSION['payment'] == "cash" || $_SESSION['payment'] == "credits" || $_SESSION['payment'] == "stripe-accept") {

    $user_id = $_SESSION['user_id'];

    if ($_SESSION['payment'] == 'khalti') {
        // Pass the total amount to Khalti page via POST
        header("Location: ../function/khaltipayment.php?amount=" . $total);
        exit;
    }

    if ($_SESSION['payment'] == 'stripe-accept') {
        $address = $_SESSION['address'];
    } else {
        $address = $_POST['billing-address'];
    }
    if ($_SESSION['payment'] == "cash") {
        $pmethod = "cash on delivery";
    } else if ($_SESSION['payment'] == "credits") {
        $pmethod = "pay balance";
    } else if ($_SESSION['payment'] == "stripe-accept") {
        $pmethod = "credit card";
    }

    function generateRandomString($length = 3)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
    $order_set = generateRandomString();

    $cartTotal = "SELECT * FROM `cart` INNER JOIN `product` ON product.product_id=cart.product_id WHERE cart.user_id='$user_id';";
    $cartTotalResult = $mysqli->query($cartTotal);
    $subtotal = 0;
    $tax = 0;

    while ($rows = $cartTotalResult->fetch_assoc()) {
        $tax += 4 * $rows['quantity'];
        $subtotal += $rows['discount'] * $rows['quantity'];
    }

    $total = $subtotal + $tax;

    $orderAdd = "INSERT INTO `order` (`order_id`, `order_set`, `product_id`, `user_id`, `quantity`, `total`, `date`, `status`, `payment_method`, `address`, `time`) SELECT NULL, '$order_set', `product_id`, `user_id`, `quantity`, '$total', current_timestamp(), 'pending', '$pmethod', '$address', current_timestamp() FROM `cart` WHERE `user_id` = '$user_id';";
    $orderAddResult = $mysqli->query($orderAdd);

    $cartSales = "SELECT * FROM `cart` INNER JOIN `product` ON product.product_id=cart.product_id WHERE cart.user_id='$user_id';";
    echo "bsdk idhar kuch galat nahi";
    $cartSalesResult = $mysqli->query($cartSales);

    while ($rows = $cartSalesResult->fetch_assoc()) {
        $sales = $rows['quantity'] + $rows['sales'];
        $ordered = $rows['ordered'] + 1;
        $product_id = $rows['product_id'];

        $updateSales = "UPDATE `product` SET `sales` = '$sales' WHERE `product`.`product_id` = '$product_id';";
        $updateSalesResult = $mysqli->query($updateSales);
        $product_id = $rows['product_id'];

        $updateOrdered = "UPDATE `product` SET `ordered` = '$ordered' WHERE `product`.`product_id` = '$product_id';";
        $updateOrderedResult = $mysqli->query($updateOrdered);
        $sales = 0;
        $ordered = 0;
    }

    $cartEmpty = "DELETE FROM `cart` WHERE `user_id` = '$user_id';";
    $cartEmptyResult = $mysqli->query($cartEmpty);

    if ($_SESSION['payment'] == 'credits') {
        $userCredits = "SELECT * FROM `users` WHERE `user_id` = '$user_id';";
        $userCreditsResult = $mysqli->query($userCredits);

        while ($rows = $userCreditsResult->fetch_assoc()) {
            $credits = $rows['credits'] - $total;
        }

        $creditUpdate = "UPDATE `users` SET `credits` = '$credits' WHERE `user_id` = '$user_id';";
        $creditUpdateResult = $mysqli->query($creditUpdate);

    }

    $mysqli->close();
    header("Location:../cart.php");
} else if ($_SESSION['payment'] == 'stripe') {

    $user_id = $_SESSION['user_id'];

    $cartStripe = "SELECT * FROM `cart` INNER JOIN `product` ON `cart`.product_id = `product`.product_id WHERE `user_id` = '$user_id';";
    $cartStripeResult = $mysqli->query($cartStripe);

    $itemsArray = array();

    while ($rows = $cartStripeResult->fetch_assoc()) {
        $stpQ = $rows['quantity'];
        $stpD = $rows['discount'] . "00";
        $stpP = $rows['product'];

        $stpQ = intval($stpQ);
        $stpD = intval($stpD);

        $productSP = array("name" => "$stpP");
        $priceSP = array("currency" => 'inr', "unit_amount" => $stpD, "product_data" => $productSP);

        $items = array("quantity" => $stpQ, "price_data" => $priceSP);

        array_push($itemsArray, $items);
    }
    $totalAmount = $stpQ * $stpD;
    // require_once '../function/khaltipayment.php';
    if ($_SESSION['payment'] == 'stripe') {
        header("Location: ../function/khaltipayment.php?amount=" . $totalAmount); // Redirect to Khalti with total amount
        exit();
    }

    http_response_code(303);
    header("Location: " . $checkout_session->url);

} else {
    echo "\n invalid";
}
?>