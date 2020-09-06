<?php
require('src/config.php');
require('src/dbconnect.php');

$pageTitle = "Order confirmation";
$pageId = "order_confirmation";

if (empty($_SESSION['cartItems'])) {
	header('Location: index.php');
	exit;
}

//count the total price
if (!isset($_SESSION['cartItems'])){
	$_SESSION['cartItems'] = [];
}
$cartItemCount 	= count($_SESSION['cartItems']);
$cartTotalsum 	= 0;
foreach ($_SESSION['cartItems'] as $cartId => $cartItem) {
	$cartTotalsum += $cartItem['price'] * $cartItem['quantity'];
}
//end of counting total price

$cartItems = $_SESSION['cartItems'];
unset($_SESSION['cartItems']);

?>

<?php include('layout/header.php');?>

<body>
    <div class="container">

        <div class="row">
            <div class="col-12">
                <a href="login.php" class="float-right">|| Log in</a>
                <!--                <a href="register.php" class="float-right">|| Sign up |</a>-->
                <a href="index.php" class="float-right mr-2"><i class="fa fa-home"> </i></a>

            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-12 text-center">
                <h1>Order sent successfully!</h1>
                <p>Check SMS/e-mail for receipt. <br>Thank you
                </p>
            </div>
        </div>
        <br>
        
         <?php foreach ($cartItems as $cartId => $cartItem) { ?>
         
         <hr>
        <div class="row text-center">
            <div class="col-sm-4 col-md-2 col-lg-2">
                <img src="image/<?=$cartItem['img']?>" width="40px" height="40px">
            </div>
<!--
            <div class="col-sm-4 col-md-2 col-lg-2">
                <?=$cartItem['description']?>
            </div>
-->
               <div class="col-sm-4 col-md-2 col-lg-2">
                Quantity: <?=$cartItem['quantity']?>
            </div>
            <div class="col-sm-4 col-md-3 col-lg-3">
                <span class="price text-info">

                    <?=$cartItem['price']?>
                </span>Tk/Item
            </div>
        </div>
        <hr>
        <?php } ?>
        
        <div class="row">
            <div class="col-8 text-center">
                <p> <strong>Total: <span class="text-info"> <?= $cartTotalsum ?> Tk</span></strong></p>
            </div>
        </div>
        <hr>
        

    </div>

    <?php include('layout/footer.php');?>
