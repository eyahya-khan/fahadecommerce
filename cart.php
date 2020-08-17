<?php
if (isset($_POST["resetBtn"])){
unset($_SESSION['cartItems']);
}
if (!isset($_SESSION['cartItems'])){
	$_SESSION['cartItems'] = [];
}
$cartItemCount 	= count($_SESSION['cartItems']);
$cartTotalsum 	= 0;
foreach ($_SESSION['cartItems'] as $cartId => $cartItem) {
	$cartTotalsum += $cartItem['price'] * $cartItem['quantity'];
}
?>
<div class="row mb-2">
    <div class="col-12 col-sm-12 col-12 main-section text-right">
        <button type="button" class="btn btn-info" data-toggle="dropdown">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge danger"><?=$cartItemCount?></span>
        </button>
        <div class="dropdown-menu col-9 mr-4">
            <div class="row total-header-section">
                <div class="col-11 text-right">
                    <form action="" method="POST">
                        <input type="submit" class="btn btn-info" name="resetBtn" value="Clear All">
                    </form>
                </div>
            </div>
            <hr>
            <?php foreach ($_SESSION['cartItems'] as $cartId => $cartItem){ ?>
            <div class="row">
                <div class="col-2 text-center">
                    <img src="image/<?=$cartItem['img']?>" width="40px" height="40px">
                </div>
                <div class="col-2 cart-detail-product">
                    <b><?=$cartItem['name']?></b>
                </div>
                <div class="col-3">
                    <span class="price text-info">
                        
                        <?=$cartItem['price']?> 
                    </span>Tk/Item
                </div>
                <div class="col-3">
                    <span class="count">
                        <?=$cartItem['quantity']?>
<!--
                   <form class="update-cart-form" action="" method="post">
                            <input type="hidden" name="cartId" value="<?=htmlentities($cartId)?>">
                            <input type="number" name="quantity" value="<?=htmlentities($cartItem['quantity'])?>" min="1" max="1000">
                            <button type="submit" class="btn btn-info">add</button>
                        </form>
-->
                    </span>
                </div>
                <div class="col-2">
                    <form action="deletecartitem.php" method="POST">
                        <input type="hidden" name="cartId" value="<?=$cartId?>">
                        <!--                        <input type="submit" class="btn btn-info" name="deleteBtn" value="Delete">-->
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
                    <p> Total: <span class="text-info"> <?= $cartTotalsum ?> Tk</span></p>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                <a href="checkout.php" class="btn btn-primary btn-block">Checkout</a>
            </div>
        </div>
    </div>
</div>
