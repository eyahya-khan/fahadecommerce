<?php
require('src/dbconnect.php');

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
<?php include('layout/header.php'); ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="login.php" class="float-right">| Log in</a>
                <a href="register.php" class="float-right">|| Sign up |</a>
                <a href="index.php" class="float-right mr-1"><i class="fa fa-home"> </i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <img src="image/IMG_1288.jpg" alt="" width="100%" height="70%" class="mt-2 mb-2">
            </div>
            <div class="col-6">
                <img src="image/IMG_1296.jpg" alt="" width="100%" height="70%" class="mt-2 mb-2">
            </div>
        </div>
        <div class="row">
            <div class="col-4 text-center">
               <h5 class="text-danger"><?php echo $post['name'];?></h5>
                <img src="image/<?php echo $post['img'];?>" width="100%" height="95%" class="mt-2">
                <a href="index.php"><input type="submit" value="Back" class="btn btn-info border-dark mb-2"></a>
            </div>
            <div class="col-4">
               <h2 class="text-center">Specification<hr></h2>
                <p class="text-justify">
                    <?php echo $post['description'];?>
                </p>
            </div>
            <div class="col-4">
                <h4 class="text-center mt-3"><?php echo $post['price'];?> taka/item</h4><br>
                <p class="text-center"><?php echo $post['quantity'];?> are available</p>
                <hr>
                
                <form action="addtocart.php" method="POST" class="text-center">
                    <input type="hidden" name="productId" value="<?=$product['id']?>">
                    <input type="number" min="0" value="1" name="quantity"><br>
                    <input type="submit" value="addtocart" name="addToCart" class="btn btn-info border-red mt-2">
                </form>
            </div>
        </div>
        
    </div><br><br><br>
    <?php include('layout/footer.php'); ?>
