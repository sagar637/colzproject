<?php
include 'connection.php';

// Retrieve the amount from the URL
if (isset($_GET['amount'])) {
    $amount = intval($_GET['amount']); // Amount passed in paisa
} else {
    $amount = 0; // Default to 0 if no amount is passed
    die("Invalid amount received.");
}

$user_id = $_SESSION['user_id'];
$address = $_SESSION['address'];
$pmethod = 'Khalti'; // Mark payment method as 'Khalti'

$error_message = "";
$successRedirect = "http://localhost/Online-Grocery-Store-Using-PHP/GardenRoots/index.php"; // Redirect after successful payment

// Insert the order into the database after the payment form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_set = generateRandomString();

    // Calculate the order total (this can be done in your original checkout logic)
    $cartTotal = "SELECT * FROM `cart` INNER JOIN `product` ON product.product_id=cart.product_id WHERE cart.user_id='$user_id';";
    $cartTotalResult = $mysqli->query($cartTotal);
    $subtotal = 0;
    $tax = 0;

    while ($rows = $cartTotalResult->fetch_assoc()) {
        $tax += 4 * $rows['quantity'];
        $subtotal += $rows['discount'] * $rows['quantity'];
    }

    $total = $subtotal + $tax;

    // Insert order into the database
    $orderAdd = "INSERT INTO `order` (`order_id`, `order_set`, `product_id`, `user_id`, `quantity`, `total`, `date`, `status`, `payment_method`, `address`, `time`) 
                SELECT NULL, '$order_set', `product_id`, `user_id`, `quantity`, '$total', current_timestamp(), 'pending', '$pmethod', '$address', current_timestamp() 
                FROM `cart` WHERE `user_id` = '$user_id';";
    
    if ($mysqli->query($orderAdd)) {
        // Empty the cart after successful order insertion
        $cartEmpty = "DELETE FROM `cart` WHERE `user_id` = '$user_id';";
        $mysqli->query($cartEmpty);

        // Redirect to success page
        echo "<span style='color:green'>Payment successful! Redirecting...</span>";
        echo "<script>setTimeout(function() { window.location='" . $successRedirect . "'; }, 2000);</script>";
    } else {
        echo "Error inserting order: " . $mysqli->error;
    }
}

// Function to generate a random string (order_set)
function generateRandomString($length = 3) {
    return substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

?>

<div class="khalticontainer">
    <center>
        <div><img src="khalti.png" alt="khalti" width="200"></div>
    </center>

    <form action="" method="post">
        <small>Mobile Number:</small> <br>
        <input type="number" class="number" minlength="10" maxlength="10" name="mobile" placeholder="98xxxxxxxx" required>
        <small>Khalti MPIN:</small> <br>
        <input type="password" class="mpin" name="mpin" minlength="4" maxlength="6" placeholder="xxxx" required>
        <small>Price:</small> <br>
        <input type="text" class="price" value="Rs. <?php echo number_format($amount / 100, 2); ?>" disabled>
        <input type="hidden" name="amount" value="<?php echo $amount; ?>">
        <br>
        <button type="submit">Simulate Payment</button>
        <br>
        <small>We don't store your credentials for security reasons. You will have to reenter your details every time.</small>
    </form>
</div>

<style>
.khalticontainer {
    width: 300px;
    border: 2px solid #5C2D91;
    margin: 0 auto;
    padding: 8px;
}

input {
    display: block;
    width: 98%;
    padding: 8px;
    margin: 2px;
}

button {
    display: block;
    background-color: #5C2D91;
    border: none;
    color: white;
    cursor: pointer;
    width: 98%;
    padding: 8px;
    margin: 2px;
}

button:hover {
    opacity: 0.8;
}
</style>
