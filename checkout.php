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
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Info</th>
                    <th scope="col"></th>
                    <th scope="col">Total</th>
                    <th scope="col">Price/Item</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($_SESSION['cartItems'] as $cartId => $cartItem) { ?>
                <tr class="border">
                    <td><img src="image/<?=htmlentities($cartItem['img'])?>" width="100" height="50px">
                    </td>
                    <td><?=htmlentities($cartItem['description'])?></td>
                    <td>
                        <!--delete item-->
                        <form action="deletecartitem.php" method="post">
                            <input type="hidden" name="cartId" value="<?=htmlentities($cartId)?>">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <!--update quantity item-->
                        <form class="update-cart-form" action="updatecartitem.php" method="post">
                            <input type="hidden" name="cartId" value="<?=htmlentities($cartId)?>">
                            <input type="number" name="quantity" value="<?=htmlentities($cartItem['quantity'])?>" min="1">
                        </form>
                    </td>
                    <td><?=htmlentities($cartItem['price'])?> SEK</td>
                </tr>
                <?php } ?>
                <tr class="border">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Total: <?=htmlentities($cartTotalsum)?> SEK</strong></td>
                </tr>
            </tbody>
        </table>
        <br><br><br>
      
        <br>
    </div>
    <?php include('layout/footer.php'); ?>
