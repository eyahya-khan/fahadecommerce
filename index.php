<?php
require('src/dbconnect.php');
    require('src/config.php');
    $pageTitle = "home page";
//fetch all information
    try {
  $query = "SELECT * FROM products;";
  $stmt = $dbconnect->query($query);
  $products = $stmt->fetchAll();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
?>
<?php include('layout/header.php');?>

<body>
    <div class="container">
<!--        <h2>Sweden Bangla trade venture background image</h2>-->
        <div class="row">
            <div class="col-12">
                <a href="login.php" class="float-right">| Log in</a>
                <a href="register.php" class="float-right">|| Sign up |</a>
                <a href="index.php" class="float-right mr-2"><i class="fa fa-home"> </i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <img src="image/IMG_1288.jpg" alt="" width="100%" height="320px" class="mt-2 mb-2">
            </div>
            <div class="col-6">
                <!--                <img src="image/IMG_1296.jpg" alt="" width="100%" height="320px" class="mt-2 mb-2">-->
                <video width="100%" height="97%" controls>
                    <source src="video/addvideo.mov" type="video/mp4">
                </video>
            </div>
        </div>
        
        <div> <?php include('cart.php');?> </div>
        
        <div class="row shadow-lg mb-3">
        <?php foreach ($products as $key => $product) { ?>
<!--        <div class="row">-->
            <div class="col-3 p-2 text-center">
                <h5 class="text-center text-danger"><?php echo $product['name'] ?></h5>
                <a href="product.php?hidID=<?=$product['id']?>"><img src="image/<?php echo $product['img']; ?>" width="100%" height="50%"></a>
                <p><strong><?php echo $product['price'] ?> TK</strong></p>
                <a href="product.php?hidID=<?=$product['id']?>">
                    <input type="submit" name="preview" value="Details" class="btn btn-outline-dark border-success mb-3 mr-2">
                </a>
                 <p><em><?php echo $product['quantity'];?> are available</em></p>
                <form action="addtocart.php" method="POST">
                    <input type="hidden" name="productId" value="<?=$product['id']?>">
                    <input type="number" min="1" max="1000" value="1" name="quantity"><br>
                    <input type="submit" value="add to cart" name="addToCart" class="btn btn-info border-red mt-2">
                </form>
            </div>
        <?php } ?>
        
            </div>
    </div>
    <?php include('layout/footer.php');?>
