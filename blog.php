<?php
include 'Function/connection.php';  

if($_SESSION["user_id"]==null){
    $_SESSION["user_id"]="0";
}
$user_id=$_SESSION["user_id"];

// get cart products
$cartDisplay = "SELECT * FROM `product` INNER JOIN `cart` ON product.product_id=cart.product_id WHERE cart.user_id='$user_id';";
$cartDisplayResult = $mysqli->query($cartDisplay);

// get blog data
$blogDisplay = "SELECT * FROM `admins` INNER JOIN `blog` ON admins.admin_id=blog.admin_id;";
$blogDisplayResult = $mysqli->query($blogDisplay);

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
    <title>Blogs</title>
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    <!-- blog section starts -->
    <div class="heading">
        <h1>our blogs</h1>
        <p class="heading-url"><a href="index.php">home </a>>> blogs </p>
    </div>

    <section class="blogs">
        <h1 class="title"> our <span>blogs</span></h1>
        <div class="box-container">

            <!-- DB DISPLAY !!!! -->
                <?php
                    while($rows=$blogDisplayResult->fetch_assoc()){
                ?>

                <div class="box">
                    <div class="image">
                        <img src="blogs/<?php echo $rows['blog_image']; ?>">
                    </div>
                    <div class="content">
                        <div class="icons">
                            <a href="#" class="blog-icon"> <i class="fas fa-calendar"></i> <?php echo $rows['date']; ?></a>
                            <a href="#" class="blog-icon"> <i class="fas fa-user"></i> by <?php echo $rows['username']; ?></a>
                        </div>
                        <h3><?php echo $rows['blog_title']; ?></h3>
                        <p><?php echo $rows['blog_data']; ?></p>
                        <a href="#" class="btn">read more</a>
                    </div>
                </div>
                
                <?php
                    }
                ?>
            <!-- DB DISPLAY !!!! -->
        </div>
    </section>
    <!-- blog section ends -->

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
                <a><i class=" footer-arrow fas fa-arrow-right"></i>orders</a>
                <a><i class=" footer-arrow fas fa-arrow-right"></i>favorites</a>
                <a><i class=" footer-arrow fas fa-arrow-right"></i>wishlist</a>
                <a><i class=" footer-arrow fas fa-arrow-right"></i>account</a>
                <a><i class=" footer-arrow fas fa-arrow-right"></i>terms and policies</a>
            </div>

            <div class="box">
                <h3>follow us</h3>
                <a><i class=" footer-arrow fab fa-facebook-f"></i>facebook</a>
                <a><i class=" footer-arrow fab fa-twitter"></i>twitter</a>
                <a><i class=" footer-arrow fab fa-instagram"></i>instagram</a>
                <a><i class=" footer-arrow fab fa-linkedin"></i>linkedin</a>
                <a><i class=" footer-arrow fab fa-twitter"></i>twitter</a>
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
    ?>
    <script src="lib/script.js"></script>
</body>
</html>