<?php
require('src/config.php');
require('src/dbconnect.php');

$pageTitle = "Order confirmation";
$pageId = "order_confirmation";

if (empty($_SESSION['cartItems'])) {
	header('Location: index.php');
	exit;
}
$cartItems = $_SESSION['cartItems'];
unset($_SESSION['cartItems']);
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

        <br>

        <h1>Thank you for order!</h1>
        <p>
            We have received your order and will manage it as soon as possible. You will receive an confirmation letter or sms to you e-mail address or to your phone. This might take few minutes. If you have any questions, please look at FAQ page or ask via chat, email or phone. Thank you for your patience.
        </p>
        <br>

        <table class="table table-borderless">
            <thead>
                <tr>
                    <th style="width: 15%">Product</th>
                    <th style="width: 50%">Info</th>
                    <th style="width: 10%">Quantity</th>
                    <th style="width: 15%">Price per product</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $cartId => $cartItem) { ?>
                <tr>
                    <td><img src="image/<?=$cartItem['img']?>" width="100"></td>
                    <td><?=$cartItem['description']?></td>
                    <td><?=$cartItem['quantity']?></td>
                    <td><?=$cartItem['price']?> kr</td>
                </tr>
                <?php } ?>

                <tr class="border-top">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Total: <?= $cartTotalsum ?> kr</b></td>
                </tr>

            </tbody>
        </table>
    </div>

    <?php include('layout/footer.php');?>
