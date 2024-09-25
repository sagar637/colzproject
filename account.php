<?php
include 'Function/connection.php';

if($_SESSION["user_id"]=="0"){
    header('Location:index.php');
}

$user_id=$_SESSION["user_id"];

// get cart products
$cartDisplay = "SELECT * FROM `product` INNER JOIN `cart` ON product.product_id=cart.product_id WHERE cart.user_id='$user_id';";
$cartDisplayResult = $mysqli->query($cartDisplay);

// get profile information
$profileDisplay = "SELECT * FROM `users` WHERE `user_id`='$user_id';";
$profileDisplayResult = $mysqli->query($profileDisplay);

// get order information
$orderDisplay = "SELECT DISTINCT `order_set`, `date`, `total`, `status` FROM `order` WHERE `user_id`='$user_id';";
$orderDisplayResult = $mysqli->query($orderDisplay);

// get address information
$addressDisplay = "SELECT * FROM `users` WHERE `user_id`='$user_id';";
$addressDisplayResult = $mysqli->query($addressDisplay);

// get account information
$accountDisplay = "SELECT * FROM `users` WHERE `user_id`='$user_id';";
$accountDisplayResult = $mysqli->query($accountDisplay);

// get order report information
if($_SESSION['orderReport'] == 'on'){
    $order_report_no = $_SESSION['orderReportNo'];
    $orderSetDisplay = "SELECT * FROM `order` INNER JOIN `product` ON product.product_id=order.product_id WHERE `order_set`='$order_report_no';";
    $orderSetDisplayResult = $mysqli->query($orderSetDisplay);

    $orderSetDisplay2 = "SELECT DISTINCT `order_set`, `date`, `total`, `status`, `address` FROM `order` INNER JOIN `product` ON product.product_id=order.product_id WHERE `order_set`='$order_report_no';";
    $orderSetDisplayResult2 = $mysqli->query($orderSetDisplay2);
}

//user credits
$creds = "SELECT * FROM `users` WHERE `user_id`='$user_id';";
$credsResult = $mysqli->query($creds);
$credits = 0;

while($rows=$credsResult->fetch_assoc()){
    $credits = $rows['credits'];
}

//cart total
$cartTotal = "SELECT * FROM `cart` INNER JOIN `product` ON product.product_id=cart.product_id WHERE cart.user_id='$user_id';";
$cartTotalResult = $mysqli->query($cartTotal);
$subtotal = 0;

while($rows=$cartTotalResult->fetch_assoc()){
    $subtotal += $rows['discount']*$rows['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="lib/style.css">
</head>
<body>

    <!-- header section starts -->
    <header class="header">
    <a class="logo">
            <img src="images/logo.png">
            Online Grocery Store
        </a>

        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="shop.php">shop</a>
            <a href="about.php">about</a>
            <a href="review.php">review</a>
            <a href="blog.php">blog</a>
            <a href="contact.php">contact</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="cart-btn" class="fas fa-shopping-cart"></div>
        <?php
            if($_SESSION["user_id"]=="0"){
                ?><div id="login-btn" class="fas fa-user"></div><?php
            }
            else{
                ?><div onclick="location.href='account.php'" class="fas fa-user"></div><?php
            }
        ?>
        </div>
        
        <form action="search.php" class="search-form">
            <input type="search" placeholder="Search Here..." name="search" id="search-box" pattern="[A-Za-z]+" required maxlength="20">
            <label for="search-box" class="fas fa-search"></label>
        </form>

        <div class="shopping-cart">
            <div class="cart-overflow">
                <!-- DB DISPLAY !!!! -->
                <?php
                    while($rows=$cartDisplayResult->fetch_assoc()){
                ?>
                    <form action="function/cart-change.php" method="POST" class="box">
                        <a onclick="this.closest('form').submit()" class="fas fa-times"></a>
                        <input type="hidden" name="op" value="remove">
                        <input type="hidden" name="product" value="<?php echo $rows['product_id']; ?>">
                        <img src="products/<?php echo $rows['product_image']; ?>">
                        <div class="content">
                            <h3><?php echo $rows['product']; ?></h3>
                            <span class="quantity"><?php echo $rows['quantity']; ?></span>
                            <span class="multiply">x</span>
                            <span class="price">Rs.<?php echo $rows['discount']; ?></span>
                        </div>
                    </form>
                <?php
                    }
                ?>
                <!-- DB DISPLAY !!!! -->
            </div>
            <h3 class="total">subtotal : <span>Rs.<?php echo $subtotal;?></span></h3>
            <?php
                if($user_id !=0){
                    echo'<a href="cart.php" class="btn">checkout cart</a>';
                }
                else{
                    echo'<a onclick="alert(`You Need To Login First !!`)" class="btn">checkout cart</a>';
                }
            ?>
        </div>

        <form action="function/login.php" method="POST" class="login-form">
            <h3>login</h3>
            <input type="text" placeholder="Username" name="username" pattern="[A-Za-z0-9]+" class="box" required maxlength="30">
            <input type="password" placeholder="Password" name="password" pattern="[A-Za-z0-9]+" class="box" required maxlength="30">
            <div class="remember">
                <input type="checkbox" name="remember" id="login-remember-me">
                <label for="login-remember-me">remember me</label>
            </div>
            <input type="hidden" name="op" value="login">
            <input type="submit" value="Log In" class="btn">
            <p class="login-func">forgot password? <a href="#">click here</a></p>
            <p class="login-func">don't have an account? <a id="register-btn">create one</a></p>
        </form>

        <form action="function/login.php" method="POST" class="register-form">
            <h3>register</h3>
            <input type="text" placeholder="Username" name="username" pattern="[A-Za-z0-9]+" class="box" required maxlength="30">
            <input type="password" placeholder="Password" name="password" pattern="[A-Za-z0-9]+" class="box" required maxlength="30">
            <input type="email" placeholder="Email ID" name="email" class="box" required maxlength="50">
            <input type="number" placeholder="Phone No" name="phone" class="box" required maxlength="10">
            <div class="remember">
                <input type="checkbox" name="remember" id="register-remember-me">
                <label for="register-remember-me">remember me</label>
            </div>
            <input type="hidden" name="op" value="register">
            <input type="submit" value="Sign Up" class="btn">
            <p class="login-func">already a user? <a id="register-close-btn">login</a></p>
        </form>
    </header>
    <!-- header section ends -->

    <!-- user section starts -->
    <div class="heading">
        <h1>account</h1>
        <p class="heading-url"><a href="index.php">home </a>>> account </p>
    </div>
    <section class="user-manage">
        <div class="user-nav">
            <div class="nav-box <?php if($_SESSION['accountOrders'] == 'on'){ echo "active-nav-box";}?>" id="user-orders" onClick="navOpen(this.id)">
                <i class="fa-solid fa-bag-shopping"></i>
                <h3>orders</h3>
            </div>
            <div class="nav-box <?php if($_SESSION['accountTrack'] == 'on'){ echo "active-nav-box";}?>" id="user-track" onClick="navOpen(this.id)">
                <i class="fa-solid fa-truck-fast"></i>
                <h3>track orders</h3>
            </div>
            
            <div class="nav-box <?php if($_SESSION['accountAddress'] == 'on'){ echo "active-nav-box";}?>" id="user-address" onClick="navOpen(this.id)">
                <i class="fa-solid fa-location-dot"></i>
                <h3>my address</h3>
            </div>
            <div class="nav-box <?php if($_SESSION['accountUpdate'] == 'on'){ echo "active-nav-box";}?>" id="user-account" onClick="navOpen(this.id)">
                <i class="fa-solid fa-user"></i>
                <h3>account details</h3>
            </div>
            <div class="nav-box" id="user-logout" onClick="location.href='function/logout.php'">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <h3>logout</h3>
            </div>
        </div>
        <div class="user-data">
            <div class="user-box" id="user-default" <?php if($_SESSION['accountUpdate'] == 'on' || $_SESSION['accountOrders'] == 'on' || $_SESSION['accountTrack'] == 'on' || $_SESSION['accountCredits'] == 'on' || $_SESSION['accountAddress'] == 'on'){ echo "style='display:none;'";}?>>
                <h3>hello user!</h3>
                <div class="default-wrapper">
                    <div class="default-profile">

                    <!-- DB DISPLAY !!!! -->
                        <?php
                            while($rows=$profileDisplayResult->fetch_assoc()){
                        ?>
                        <div class="image-container">
                            <img src="pfp/<?php echo $rows['profile_pic']?>">
                        </div>
                        <h3><?php echo $rows['username']?></h3>
                        <h3><?php echo $rows['email']?></h3>
                        <?php
                            }
                        ?>
                    <!-- DB DISPLAY !!!! -->

                    </div>
                    <p class="default-info">
                        from your account dashboard you can easily check & <a> view your recent orders</a>.
                        <br><br>
                        manage your addresses and <a>edit your password and account details</a>.
                    </p>
                </div>
            </div>

            <div class="user-box <?php if($_SESSION['accountOrders'] == 'on'){ echo "active-user-box";}?>" id="user-orders-box">
                <h3>your orders</h3>
                <table class="order-table" cellspacing="0">
                    <tr>
                        <th>order</th>
                        <th>date</th>
                        <th>status</th>
                        <th>total</th>
                        <th>action</th>
                    </tr>

            <!-- DB DISPLAY !!!! -->
                <?php
                    while($rows=$orderDisplayResult->fetch_assoc()){
                        $order_set = $rows['order_set'];
                        $orderCount = "SELECT * FROM `order` WHERE `user_id`='$user_id' AND `order_set`='$order_set';";
                        $orderCountResult = $mysqli->query($orderCount);
                ?>
                    <tr>
                        <td>#<?php echo $rows['order_set']?></td>
                        <td><?php echo $rows['date']?></td>
                        <td><?php echo $rows['status']?></td>
                        <td>Rs.<?php echo $rows['total']?> for <?php echo mysqli_num_rows($orderCountResult);?> items</td>
                        <td class="user-order-open"> 
                            <form action="function/order-view.php" method="post">
                                <input type="hidden" name="orderReportNo" value="<?php echo $rows['order_set']?>">
                                <a onclick = "this.closest('form').submit()">view</a>
                            </form>
                        </td>
                    </tr>

                <?php
                    }
                ?>
            <!-- DB DISPLAY !!!! -->

                </table>

                <?php 
                if(mysqli_num_rows($orderDisplayResult) == 0){
                    echo "<h4>you havent ordered anything recently</h4>";
                    echo "<script>document.querySelector('.order-table').classList.add('table-hide');</script>";
                }        
                ?>
                
            </div>

            <form action="function/account-track.php" method="POST" class="user-box <?php if($_SESSION['accountTrack'] == 'on'){ echo "active-user-box";}?>" id="user-track-box">
                <h3>orders tracking</h3>
                <p>To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>

                <h2>order ID</h2>
                <input type="text" name="id" pattern="[A-Za-z0-9]+" required maxlength="3">

                <h2>billing email</h2>
                <input type="email" name="email" required maxlength="50">
            <?php
                if($_SESSION['trackReport'] != 'off'){?>
                    <h2><?php echo $_SESSION['trackReport'];?></h2>      
            <?php
                    $_SESSION['trackReport'] = 'off';
                }
                ?>
                <input type="submit" value="track" class="btn">
            </form>

            

            <div class="user-box <?php if($_SESSION['accountAddress'] == 'on'){ echo "active-user-box";}?>" id="user-address-box">
                <h3>billing address</h3>
                <div class="address-container">
            <?php
                while($rows=$addressDisplayResult->fetch_assoc()){    
            ?>
                <?php
                    if($rows['add1']!=''){
                ?>
                    <form action="function/account-address.php" method="POST" class="user-address-form">
                        <textarea name="address" id="add1" cols="18" rows="7" disabled maxlength="100"><?php echo $rows['add1'];?></textarea>
                        <a class="btn address-edit" onclick="this.closest('form').classList.add('address-active'); document.querySelector('#add1').disabled=0;">edit</a>
                        <input type="hidden" name="number" value="add1">
                        <input type="submit" value="save" class="btn address-submit" style="display:none;">
                    </form>
                <?php
                    }
                    else{
                ?>
                    <form action="function/account-address.php" method="POST" class="user-address-form">
                        <textarea name="address" cols="18" rows="7" required maxlength="100"></textarea>
                        <input type="hidden" name="number" value="add1">
                        <input type="submit" value="add" class="btn">
                    </form>
                <?php
                    }
                ?>
                <?php
                    if($rows['add2']!=''){
                ?>
                    <form action="function/account-address.php" method="POST" class="user-address-form">
                        <textarea name="address" id="add2" cols="18" rows="7" disabled maxlength="100"><?php echo $rows['add2'];?></textarea>
                        <a class="btn address-edit" onclick="this.closest('form').classList.add('address-active'); document.querySelector('#add2').disabled=0;">edit</a>
                        <input type="hidden" name="number" value="add2">
                        <input type="submit" value="save" class="btn address-submit" style="display:none;">
                    </form>
                <?php
                    }
                    else{
                ?>
                    <form action="function/account-address.php" method="POST" class="user-address-form">
                        <textarea name="address" cols="18" rows="7" required maxlength="100"></textarea>
                        <input type="hidden" name="number" value="add2">
                        <input type="submit" value="add" class="btn">
                    </form>
                <?php
                    }
                ?>
                <?php
                    if($rows['add3']!=''){
                ?>
                    <form action="function/account-address.php" method="POST" class="user-address-form">
                        <textarea name="address" id="add3" cols="18" rows="7" disabled maxlength="100"><?php echo $rows['add3'];?></textarea>
                        <a class="btn address-edit" onclick="this.closest('form').classList.add('address-active'); document.querySelector('#add3').disabled=0;">edit</a>
                        <input type="hidden" name="number" value="add3">
                        <input type="submit" value="save" class="btn address-submit" style="display:none;">
                    </form>
                <?php
                    }
                    else{
                ?>
                    <form action="function/account-address.php" method="POST" class="user-address-form">
                        <textarea name="address" cols="18" rows="7" required maxlength="100"></textarea>
                        <input type="hidden" name="number" value="add3">
                        <input type="submit" value="add" class="btn">
                    </form>
                <?php
                    }
                ?>
            <?php
                }
            ?>
                </div>
            </div>
            
            <!-- DB DISPLAY !!!! -->
            <?php
                while($rows=$accountDisplayResult->fetch_assoc()){
            ?>
                <form action="function/account-change.php" method="POST" class="user-box <?php if($_SESSION['accountUpdate'] == 'on'){ echo "active-user-box";}?>" id="user-account-box" enctype="multipart/form-data">
                    <h3>manage account</h3>

                    <h2>username</h2>
                    <input type="text" name="username" placeholder="<?php echo $rows['username']?>" pattern="[A-Za-z0-9]+" maxlength="30">

                    <h2>phone number</h2>
                    <input type="number" name="phone" placeholder="<?php echo $rows['phone']?>" maxlength="10">

                    <h2>email address</h2>
                    <input type="email" name="email" placeholder="<?php echo $rows['email']?>" maxlength="50">

                    <h2>new password</h2>
                    <input type="password" name="pass" pattern="[A-Za-z0-9]+" maxlength="30">

                    <h2>add profile picture</h2>
                    <input type="file" name="profile" id="profile" accept="image/*">
                    
                    <h2>confirm password*</h2>
                    <input type="password" name="passcheck" pattern="[A-Za-z0-9]+" required maxlength="30">

                    <input type="submit" value="Save Changes" class="btn">
                </form>
            <?php
                }
            ?>
            <!-- DB DISPLAY !!!! -->

        </div>
    </section>
    <!-- user section ends -->

    <!-- footer section starts -->
    <footer class="footer">
        <div class="box-container">
            <div class="box">
                <h3>quick links</h3>
                <a href="index.php"><i class=" footer-arrow fas fa-arrow-right"></i> index</a>
                <a href="shop.php"><i class=" footer-arrow fas fa-arrow-right"></i> shop</a>
                <a href="about.php"><i class=" footer-arrow fas fa-arrow-right"></i> about</a>
                <a href="review.php"><i class=" footer-arrow fas fa-arrow-right"></i> review</a>
                <a href="blog.php"><i class=" footer-arrow fas fa-arrow-right"></i> blog</a>
                <a href="contact.php"><i class=" footer-arrow fas fa-arrow-right"></i> contact</a>
            </div>

            <div class="box">
                <h3>extra links</h3>
                <a href=""><i class=" footer-arrow fas fa-arrow-right"></i>orders</a>
                <a href=""><i class=" footer-arrow fas fa-arrow-right"></i>favorites</a>
                <a href=""><i class=" footer-arrow fas fa-arrow-right"></i>wishlist</a>
                <a href=""><i class=" footer-arrow fas fa-arrow-right"></i>account</a>
                <a href=""><i class=" footer-arrow fas fa-arrow-right"></i>terms and policies</a>
            </div>

            <div class="box">
                <h3>follow us</h3>
                <a href=""><i class=" footer-arrow fab fa-facebook-f"></i>facebook</a>
                <a href=""><i class=" footer-arrow fab fa-twitter"></i>twitter</a>
                <a href=""><i class=" footer-arrow fab fa-instagram"></i>instagram</a>
                <a href=""><i class=" footer-arrow fab fa-linkedin"></i>linkedin</a>
                <a href=""><i class=" footer-arrow fab fa-twitter"></i>twitter</a>
            </div>

            <div class="box">
                <h3>newsletter</h3>
                <p>subscribe for latest updates</p>
                <form action="" class="newsletter">
                    <input type="email" placeholder="Enter Your Email" name="newsletterMail" >
                    <input type="submit" value="subscribe" class="btn">
                </form>
            </div>
        </div>
    </footer>
    <div class="border"></div>

    <?php
        if($_SESSION['orderReport'] == 'on'){
    ?>
    <div class="order-overlay
    <?php if($_SESSION['orderReport'] == 'on'){echo 'order-overlay-active';}?>">
        <div class="order-container">
            <form action="function/order-cancel.php" class="order-display">
                <table onscroll="disableScrolling()" onmousewheel="enableScrolling()" onmouseout="disableScrolling()" onmousemove="enableScrolling()">
                    <tr>
                        <th colspan="2">product</th>
                        <th>unit price</th>
                        <th>quantity</th>
                        <th>total</th>
                    </tr>
                    <!-- DB DISPLAY !!!! -->
                        <?php
                            while($rows=$orderSetDisplayResult->fetch_assoc()){
                        ?>

                        <tr>
                            <td class="cart-table-data"><img src="products/<?php echo $rows['product_image']; ?>"></td>
                            <td class="cart-table-data"><?php echo $rows['product']; ?></td>
                            <td class="cart-table-data">Rs.<?php echo $rows['discount']; ?></td>
                            <td class="cart-table-data"><?php echo $rows['quantity']; ?></td>
                            <td class="cart-table-data">Rs.<?php echo ($rows['discount'] * $rows['quantity']); ?></td>
                        </tr>

                        <?php
                            }
                        ?>
                    <!-- DB DISPLAY !!!! -->
                </table>
                <div class="cart-total">
                    <!-- DB DISPLAY !!!! -->
                    <?php
                        while($rows=$orderSetDisplayResult2->fetch_assoc()){
                    ?>
                    <span>
                        delivery address : 
                    </span>
                    <textarea id="address-display" rows="4" maxlength="100" disabled><?php echo $rows['address']; ?></textarea>
                    <div class="total-calc">
                        <p class="total-display">order status: <span><?php echo $rows['status']; ?></span></p>
                    </div>
                    <div class="total-calc">
                        <p class="total-display">total: <span>Rs.<?php echo $rows['total']; ?></span></p>
                    </div>
                    <?php
                        if($rows['status']!='delivered'){
                            ?><input type="submit" value="cancel order" class="btn"><?php
                        }
                        else{
                            ?><input type="submit" value="refund order" class="btn"><?php
                        }
                    ?>
                    <?php
                        }
                    ?>
                    <!-- DB DISPLAY !!!! -->
                </div>
                <a class="order-close-btn" onclick="document.querySelector('.order-overlay').classList.remove('order-overlay-active')">close</a>
            </form>
        </div>
    </div>
    <?php
        }
    ?>
    <!-- footer section ends -->
    <?php
    if($_SESSION['cart']=='on'){
        echo "<script>document.querySelector('.shopping-cart').classList.add('cart-active');</script>";
        $_SESSION['cart']='off';
    }
    
    if($_SESSION['login']=='on'){
        echo "<script>document.querySelector('.login-form').classList.add('login-active');</script>";
        echo "<script>setTimeout(() => {alert('Username Or Password Incorrect');}, 500);</script>";
        $_SESSION['login']='off';
    }
    
    if($_SESSION['register']=='on'){
        echo "<script>document.querySelector('.register-form').classList.add('login-active');</script>";
        echo "<script>setTimeout(() => {alert('Username Already Taken');}, 500);</script>";
        $_SESSION['register']='off';
    }
    
    if(isset($_SESSION['trackOrderError'])){
        if($_SESSION['trackOrderError'] == 'on'){
            echo "<script>setTimeout(() => {alert('No Order Found With That Billing Address');}, 500);</script>";
            $_SESSION['trackOrderError'] = 'off';
        }
    }
    if(isset($_SESSION['updateUsernameSame'])){
        if($_SESSION['updateUsernameSame'] == 'on'){
            echo "<script>setTimeout(() => {alert('Username Already Taken');}, 500);</script>";
            $_SESSION['updateUsernameSame'] = 'off';
        }
    }
    if(isset($_SESSION['updateEmailSame'])){
        if($_SESSION['updateEmailSame'] == 'on'){
            echo "<script>setTimeout(() => {alert('Provided Email Is Already Registered');}, 500);</script>";
            $_SESSION['updateEmailSame'] = 'off';
        }
    }
    if(isset($_SESSION['updateFieldsEmpty'])){
        if($_SESSION['updateFieldsEmpty'] == 'on'){
            echo "<script>setTimeout(() => {alert('Please Select Atleast 1 Field To Be Updated');}, 500);</script>";
            $_SESSION['updateFieldsEmpty'] = 'off';
        }
    }
    if(isset($_SESSION['updatePassWrong'])){
        if($_SESSION['updatePassWrong'] == 'on'){
            echo "<script>setTimeout(() => {alert('The Password Provided Is Incorrect');}, 500);</script>";
            $_SESSION['updatePassWrong'] = 'off';
        }
    }
    $_SESSION['accountUpdate'] = 'off';
    $_SESSION['accountOrders'] = 'off';
    $_SESSION['accountTrack'] = 'off';
    $_SESSION['accountCredits'] = 'off';
    $_SESSION['accountAddress'] = 'off';
    $_SESSION['orderReport'] = 'off';
    ?>
    <script src="lib/script.js"></script>
</body>
</html>