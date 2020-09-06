<?php
    require('../src/dbconnect.php');
    require('../src/config.php');
    $pageTitle = "admin productlist";


//check username and password have value or not
if(isset($_SESSION['firstname'])){
    $loginUsername = $_SESSION['firstname'];
}else{
    redirect('../login.php');
}
//remove username and password
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    redirect('../index.php');
}

//add
$message = '';
$error   = '';
if(isset($_POST['add'])){
    $title   = trim($_POST['name']);
    $price   = trim($_POST['price']);
$description = trim($_POST['description']);
$quantity    = trim($_POST['quantity']);
$category    = trim($_POST['category']);
$file_name   = $_FILES['file']['name'];
$file_loc    = $_FILES['file']['tmp_name'];
$file_store  = "../image/".$file_name;
    
//validation of product name
  if (empty($title)) {
      $error .=  '<li> Product name must not be empty</li>';
  }else if(is_numeric($title)){
      $error .=  '<li> Product name: Only number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z0-9 ]*$/",$title)){
       $error .=  '<li> Product name: Only letter, number and whitespace are allowed</li>'; 
  }else if(strlen($title) > 90){
       $error .=  '<li> Product name must have less than 90 characters</li>'; 
  }else if(strlen($title) < 5){
       $error .=  '<li> Product name must have 4 characters long</li>'; 
  }
//validation of price
  if(empty($price)){
      $error .=  '<li> Price must not be empty</li>';
  }else if(!preg_match('/^(0|[1-9]\d*)(\.\d{2})?$/',$price)){
       $error .=  '<li> Price: Seems wrong price, 00/00.00 are right format</li>';
  }else if(strlen($price) > 9){
       $error .=  '<li>Price seems too high</li>';
  }else if(strlen($price) < 2){
       $error .=  '<li> Price seems too low</li>';
  }
 //validation of product description
$firstWord=explode(' ',trim($_POST['description']));
  if(empty($description)){
      $error .=  '<li> Product description must not be empty</li>';
  }else if(is_numeric($description)){
      $error .=  '<li> Product description: number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z]$/",$description[0])){
       $error .=  '<li>  Product description: start with letter</li>';
  }else if(!preg_match("/^[a-zA-Z ]*$/", substr($description, 0, 10))){
       $error .=  '<li>  Product description: First 15 character should have letter</li>';
  }else if(strlen($description) < 20){
       $error .=  '<li>  Product description should have at least 20 character</li>';
  }else if(strlen($firstWord[0]) > 10){
       $error .=  '<li> First word is too long. *Use space to make it short</li>';
  }
//validation of product category
  if (empty($category)) {
      $error .=  '<li> Product category must not be empty</li>';
  }else if(is_numeric($category)){
      $error .=  '<li> Product category: Only number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z0-9 ]*$/",$category)){
       $error .=  '<li> Product category: Only letter, number and whitespace are allowed</li>'; 
  }else if(strlen($category) > 90){
       $error .=  '<li> Product category must have less than 90 characters</li>'; 
  }else if(strlen($category) < 3){
       $error .=  '<li> Product category must have 4 characters long</li>'; 
  }
   //validation of quantity
  if(empty($quantity)){
      $error .=  '<li> Quantity must not be empty</li>';
  }else if(!is_numeric($quantity)){
       $error .=  '<li>Quantity must number</li>';
  }

  if($error){
       $message =  "<ul style='background-color:#f8d7da;'>{$error}</ul>";
    }
    else {
if(!move_uploaded_file($file_loc, $file_store)){
}else{
    
    $ProductHandler -> add();       
    
  }
}
}

// delete
if(isset($_POST['deleteBtn'])){
    $id   = trim($_POST['hidId']);
    
    $ProductHandler -> delete();  

  }
//update
    if (isset($_POST['updateBtn'])) {    
    $name    = trim($_POST['name']);
    $price   = trim($_POST['price']);
$description = trim($_POST['description']);
$quantity    = trim($_POST['quantity']);
$category    = trim($_POST['category']);
      $id    = trim($_POST['id']);

       //validation of product name
  if (empty($name)) {
      $error .=  '<li> Product name must not be empty</li>';
  }else if(is_numeric($name)){
      $error .=  '<li> Product name: Only number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z0-9 ]*$/",$name)){
       $error .=  '<li> Product name: Only letter, number and whitespace are allowed</li>'; 
  }else if(strlen($name) > 90){
       $error .=  '<li> Product name must have less than 90 characters</li>'; 
  }else if(strlen($name) < 5){
       $error .=  '<li> Product name must have 4 characters long</li>'; 
  }
//validation of price
  if(empty($price)){
      $error .=  '<li> Price must not be empty</li>';
  }else if(!preg_match('/^(0|[1-9]\d*)(\.\d{2})?$/',$price)){
       $error .=  '<li> Price: Seems wrong price, 00/00.00 are right format</li>';
  }else if(strlen($price) > 9){
       $error .=  '<li>Price seems too high</li>';
  }else if(strlen($price) < 2){
       $error .=  '<li> Price seems too low</li>';
  }
 //validation of product description
$firstWord=explode(' ',trim($_POST['description']));
  if(empty($description)){
      $error .=  '<li> Product description must not be empty</li>';
  }else if(is_numeric($description)){
      $error .=  '<li> Product description: number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z]$/",$description[0])){
       $error .=  '<li>  Product description: start with letter</li>';
  }else if(!preg_match("/^[a-zA-Z ]*$/", substr($description, 0, 10))){
       $error .=  '<li>  Product description: First 15 character should have letter</li>';
  }else if(strlen($description) < 20){
       $error .=  '<li>  Product description should have at least 20 character</li>';
  }else if(strlen($firstWord[0]) > 10){
       $error .=  '<li> First word is too long. *Use space to make it short</li>';
  }
//validation of product category
  if (empty($category)) {
      $error .=  '<li> Product category must not be empty</li>';
  }else if(is_numeric($category)){
      $error .=  '<li> Product category: Only number is not allowed</li>';
  }else if(!preg_match("/^[a-zA-Z0-9 ]*$/",$category)){
       $error .=  '<li> Product category: Only letter, number and whitespace are allowed</li>'; 
  }else if(strlen($category) > 90){
       $error .=  '<li> Product category must have less than 90 characters</li>'; 
  }else if(strlen($category) < 3){
       $error .=  '<li> Product category must have 4 characters long</li>'; 
  }
   //validation of quantity
  if(empty($quantity)){
      $error .=  '<li> Quantity must not be empty</li>';
  }else if(!is_numeric($quantity)){
       $error .=  '<li>Quantity must number</li>';
  }

  if($error){
       $message =  "<ul style='background-color:#f8d7da;'>{$error}</ul>";
    }
    else { 
      $ProductHandler -> update();  
    }
    }
    


//fetch all information
 $products = $ProductHandler -> bringAll();

?>

<?php include('../layout/header.php'); ?>

<body>

    <div class="container">

        <form action="" method="POST">
            <div class="input-group-append mt-3 d-flex justify-content-end">
                <!--display user name-->
                <label class="mt-2 mr-2"><?php echo 'Welcome '.ucfirst($loginUsername); ?></label>
                <input type="submit" name="logout" value="Log out" class="btn btn-outline-dark border-info">
            </div>
        </form>

        <h2>Sweden Bangla trade venture background image</h2>
        <p>Sweden Bangla trade venture menu</p>
        <a href="orders.php"><button class="btn btn-info">Back to Order</button></a><br><br>
        <!--display error message-->
        <div id="form-message"><?=$message?></div>

        <form action="" method="post" enctype="multipart/form-data">
            <!--   <label>Name:</label>-->
            <input type="text" name="name" placeholder="Product name">
            <!--   <label>Price:</label>-->
            <input type="text" name="price" placeholder="Price/unit">
            <label>Choose Image:</label>
            <input type="file" name="file"><br>
            <textarea name="description" class="form-control mb-1" placeholder="Product Description" rows="5" cols="30"></textarea>
            <input type="text" name="quantity" placeholder="quantity">
            <input type="text" name="category" placeholder="Category"><br><br>

            <input type="submit" name="add" value="Add">
        </form>
        <br>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $key => $product) { ?>
                <tr>
                    <td><?php echo $product['quantity']; ?> </td>
                    <td><img src="../image/<?php echo $product['img']; ?>" width="50px" height="50px"></td>
                    <td><?php echo $product['name']; ?> </td>
                    <td><?php echo $product['price']; ?> </td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['category']; ?></td>
                    <td>
                        <!--delete-->
                        <form action="" method="POST" class="float-right">
                            <input type="hidden" name="hidId" value="<?=$product['id']?>">
                            <input type="submit" name="deleteBtn" value="Delete" class="btn btn-danger delete-product-btn">
                        </form>
                        <!--Update post-->
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal" data-name="<?=htmlentities($product['name'])?>" data-price="<?=htmlentities($product['price'])?>" data-quantity="<?=htmlentities($product['quantity'])?>" data-category="<?=htmlentities($product['category'])?>" data-description="<?=htmlentities($product['description'])?>" data-id="<?=htmlentities($product['id'])?>">Update</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!--update modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-info">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Update Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Product Name: </label>
                            <input type="text" class="form-control" name="name" for="recipient-name">
                            <label for="recipient-name" class="col-form-label">Description: </label>
                            <textarea class="form-control" name="description" for="recipient-name" rows="4"></textarea>
                            <label for="recipient-name" class="col-form-label">Price/Unit: </label>
                            <input type="text" class="form-control" name="price" for="recipient-name">
                            <label for="recipient-name" class="col-form-label">Quantity: </label>
                            <input type="text" class="form-control" name="quantity" for="recipient-name">
                            <label for="recipient-name" class="col-form-label">Category: </label>
                            <input type="text" class="form-control" name="category" for="recipient-name">
                            <!--                            <input type="file" class="form-control" name="file" for="recipient-name">-->
                            <input type="hidden" class="form-control" name="id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" name="updateBtn" value="Update" class="btn btn-success update-product-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var name = button.data('name'); // Extract info from data-* attributes
            var price = button.data('price'); // Extract info from data-* attributes
            var description = button.data('description'); // Extract info from data-* attributes
            //        var file        = button.data('file'); // Extract info from data-* attributes
            var quantity = button.data('quantity'); // Extract info from data-* attributes
            var category = button.data('category'); // Extract info from data-* attributes
            var id = button.data('id'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find(".modal-body input[name='name']").val(name);
            modal.find(".modal-body textarea[name='description']").val(description);
            modal.find(".modal-body input[name='price']").val(price);
            modal.find(".modal-body input[name='quantity']").val(quantity);
            modal.find(".modal-body input[name='category']").val(category);
            //        modal.find(".modal-body input[name='file']").val(file);
            modal.find(".modal-body input[name='id']").val(id);
        });

    </script>

    <?php include('../layout/.php'); ?>
