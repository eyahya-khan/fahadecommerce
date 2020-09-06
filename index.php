<?php
require('src/dbconnect.php');
    require('src/config.php');
    $pageTitle = "Sweden Bangla";
//check username and password have value or not
//if(isset($_SESSION['firstname'])){
//    $loginUsername = $_SESSION['firstname'];
//}else{
//    redirect('product.php');
//}
//remove username and password
//if(isset($_POST['logout'])){
//    session_unset();
//    session_destroy();
//    redirect('index.php');
//}

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
    <div class="container-fluid">
        <!--<h2>Sweden Bangla trade venture background image</h2>-->
        <div class="row">
            <div class="col-12">
                <a href="login.php" class="float-right">| Log in</a>
                <a href="" class="float-right">|| About us |</a>
                <a href="index.php" class="float-right mr-2"><i class="fa fa-home"> </i></a>

                <!--
                   <form action="" method="POST">
                    <div class="input-group-append mt-3 d-flex justify-content-end">
                        display user name
                        <label class="mt-2 mr-2"><?php echo 'Welcome '.ucfirst($loginUsername); ?></label>
                        <input type="submit" name="logout" value="Log out" class="btn btn-outline-dark border-info">
                    </div>
                </form>
-->

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <img src="image/IMG_1288.jpg" alt="" width="100%" height="100%" class="mt-2 mb-2">

                </div>
                <div class="col-lg-12 col-md-6 col-sm-12">
                    <video width="100%" height="100%" controls>
                        <source src="video/addvideo.mov" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <!--                <img src="image/IMG_1296.jpg" alt="" width="100%" height="320px" class="mt-2 mb-2">-->

                <div id="myCarousel" class="carousel slide">

                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <li class="item1 active"></li>
                        <li class="item2"></li>
                        <li class="item3"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="image/IMG_1288.jpg" alt="Los Angeles" width="100%" height="100%">
                        </div>
                        <div class="carousel-item">
                            <img src="image/IMG_1294.JPG" alt="Chicago" width="100%" height="100%">
                        </div>
                        <div class="carousel-item">
                            <img src="image/IMG_1295.JPG" alt="New York" width="100%" height="100%">
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#myCarousel">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>


            </div>
        </div>

        <div> <?php include('cart.php');?> </div>

        <div class="row shadow-lg mb-3">
            <?php foreach ($products as $key => $product) { ?>
            <!--        <div class="row">-->
            <div class="col-lg-3 col-md-6 col-sm-6 p-2 text-center">
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
