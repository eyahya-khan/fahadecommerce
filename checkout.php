<?php
//session_start();
// database connection
require('src/dbconnect.php');
require('src/config.php');
$pageTitle = 'Checkout';
//show all product list
//$products = $ProductHandler -> bringAll();
//fetch all information
    try {
	$stmt = $dbconnect->prepare("SELECT name,description,price,img,quantity FROM products
    WHERE id = :id");
    $stmt->bindValue(':id',$_GET['hidID']);
    $stmt->execute();
	$post = $stmt->fetch(); 
} catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
?>
<?php include('layout/header.php');?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="login.php" class="float-right">| Log in</a>
                <a href="register.php" class="float-right">|| Sign up |</a>
                <a href="index.php" class="float-right mr-2"><i class="fa fa-home"> </i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <img src="image/IMG_1288.jpg" alt="" width="100%" height="120px" class="mt-2 mb-2">
            </div>
        </div>
        <div> <?php include('cart.php'); ?></div>
        <br>

        <!--        <div class="row mr-4">-->
        <div class="row">
            <div class="col-6 text-right">
                <h1>Checkout</h1>
            </div>
            <div class="col-5 text-right">
                <form action="" method="POST">
                    <input type="submit" class="btn btn-info" name="resetBtn" value="Clear All">
                </form>
            </div>
        </div>


        <?php foreach ($_SESSION['cartItems'] as $cartId => $cartItem){ ?>

        <hr>
        <div class="row">
            <div class="col-sm-4 col-md-2 col-lg-2">
                <img src="image/<?=$cartItem['img']?>" width="40px" height="40px">
            </div>
            <div class="col-sm-4 col-md-2 col-lg-2">
                <b><?=$cartItem['name']?></b>
            </div>
            <div class="col-sm-4 col-md-3 col-lg-3">
                <span class="price text-info">

                    <?=$cartItem['price']?>
                </span>Tk/Item
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <span class="count">
                    <!--Quantity:<?=$cartItem['quantity']?>-->
                    <form class="update-cart-form" action="updatecartitem.php" method="post">
                        <input type="hidden" name="cartId" value="<?=htmlentities($cartId)?>">
                        <input type="number" name="quantity" value="<?=htmlentities($cartItem['quantity'])?>" min="1" max="1000">
                        <button type="submit" class="btn btn-info">Update</button>
                    </form>
                </span>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6">
                <form action="deletecartitem.php" method="POST">
                    <input type="hidden" name="cartId" value="<?=$cartId?>">
                    <!--<input type="submit" class="btn btn-info" name="deleteBtn" value="Delete">-->
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        <hr>

        <?php } ?>
        <div class="row">
            <div class="col-4 text-center">
                <p>Total Item: <span class="text-info"><?=$cartItemCount?> </span></p>
            </div>
            <div class="col-8 text-center">
                <p> <strong>Total: <span class="text-info"> <?= $cartTotalsum ?> Tk</span></strong></p>
            </div>
        </div>
        <hr>
        <!--</div>-->
        <!--
        <div class="row">
            <p>If you are member! <a href="login.php"><input type="submit" value="Sign in" class="btn btn-info border-dark mb-2"></a></p>
            <p> New user? <a href="register.php"><input type="submit" value="Sign up" class="btn btn-info border-dark mb-2"></a></p>
        </div>
-->

        <?php include('checkout-user-form.php'); ?>


        <div class="row">
            <div class="col-12">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="24ZBLP4SHW762">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>


            </div>

        </div>


    </div>
    <?php include('layout/footer.php'); ?>
