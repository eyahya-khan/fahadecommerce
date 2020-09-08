<?php
require('src/dbconnect.php');
    require('src/config.php');
    $pageTitle = "Sweden Bangla";



//fetch all information
    try {
  $query = "SELECT * FROM products;";
  $stmt = $dbconnect->query($query);
  $products = $stmt->fetchAll();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

//count total no of product
$numberofproduct = COUNT($products);
//count total number of page
$per_page = 4;
$start = 0;
$current_page = 1;
$record = $numberofproduct;
$pegi = ceil($record/$per_page);

if(isset($_GET['start'])){
    $start = $_GET['start'];
    //if some one put value 0 or less than 0 or greater than page no in url
    if($start <= 0){
        $start = 0;
        $current_page = 1;
    }elseif($start > $pegi){
       $start = 0;
       $current_page = 1;  
    }else{
    $current_page = $start;
    $start--;
    $start = $start*$per_page;
    }
    
}

//display product according to per page
try {
  $query = "SELECT * FROM products limit $start, $per_page;";
  $stmt = $dbconnect->query($query);
  $products = $stmt->fetchAll();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}



//fetch all information for dropdown list
    try {
  $query = "SELECT * FROM products;";
  $stmt = $dbconnect->query($query);
  $prods = $stmt->fetchAll();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

$totalprod = count($prods);


//fetch all information for first display
    try {
  $query = "SELECT * FROM products limit 1,4;";
  $stmt = $dbconnect->query($query);
  $prod = $stmt->fetchAll();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

//fetch all information by category
    try {
	$stmt = $dbconnect->prepare("SELECT * FROM products
    WHERE category = :category");
    $stmt->bindValue(':category',$_GET['list']);
    $stmt->execute();
	$posts = $stmt->fetchAll(); 
} catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
if(isset($_GET['start'])){
    
    $xyd = $products;
}elseif(isset($_GET['list'])){
    $xyd = $posts;
}else{
    $xyd = $prod;
}

//for($x = 1; $x <= $totalprod; $x++){
//   
//    
//}

?>
<?php include('layout/header.php');?>

<body>
    <div class="container-fluid">
     
        <div class="row">
            <div class="col-12">
                <a href="login.php" class="float-right">| Log in</a>
                <a href="" class="float-right">|| About us |</a>
                <a href="index.php" class="float-right mr-2"><i class="fa fa-home"> </i></a>

            </div>
        </div>
<!--
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
-->
            
                <!--carousel start-->
<!--                <div id="myCarousel" class="carousel slide">-->

                    <!-- Indicators -->
<!--
                    <ul class="carousel-indicators">
                        <li class="item1 active"></li>
                        <li class="item2"></li>
                        <li class="item3"></li>
                    </ul>
-->

                    <!-- The slideshow -->
<!--
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
-->

                    <!-- Left and right controls -->
<!--
                    <a class="carousel-control-prev" href="#myCarousel">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
-->
                <!--carousel end-->


<!--            </div>-->
<!--        </div>-->

        <div> <?php include('cart.php');?> </div>
        <div class="row">
        <div class="col-6">
        <!-- pagination start-->
        <ul class="pagination">
        <?php for ($i = 1; $i<=$pegi; $i++) { 
        //active page
        $class = '';
        if($current_page == $i){
          $class = 'active';
          }
         ?>
        <li class="page-item <?php echo $class?>"><a class="page-link" href="?start=<?php echo $i ?>"><?php echo $i ?></a></li>
        <?php } ?>
        </ul>
        <!-- pagination end-->
        </div>
<!--search by category start-->
        <div class="col-6">
             <div class="dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                  Search by category
                </button>
                <div class="dropdown-menu">
                   <?php foreach ($prods as $key => $product) { ?>
                  <a class="dropdown-item" href="?list=<?php echo $product['category']?>"><?php echo $product['category'] ?></a>
                     <?php } ?>
    
                    </div>
                  </div>
        
        </div>
<!--        search by category end-->
        </div>

        <div class="row shadow-lg mb-3">
            <?php foreach ($xyd as $key => $product) { ?>
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
    

