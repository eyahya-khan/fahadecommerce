<?php
require('src/dbconnect.php');
//add
if(isset($_POST['add'])){
    $title   = trim($_POST['name']);
    $price   = trim($_POST['price']);
$description = trim($_POST['description']);
$quantity    = trim($_POST['quantity']);
$file_name   = $_FILES['file']['name'];
$file_loc    = $_FILES['file']['tmp_name'];
$file_store  = "image/".$file_name;
if(!move_uploaded_file($file_loc, $file_store)){
}else{
    try {
      $query = "
        INSERT INTO products (name, price, description, img, quantity)
        VALUES (:name,:price, :description, :image, :quantity);
      ";
      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':name', $title);
      $stmt->bindValue(':price', $price);
      $stmt->bindValue(':description', $description);
      $stmt->bindValue(':image', $file_name);
      $stmt->bindValue(':quantity', $quantity);
      $stmt->execute();    
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }    
}
}
// delete from table
if(isset($_POST['deleteBtn'])){
    $id   = trim($_POST['hidId']);
try {
    $query = "
      DELETE FROM products
      WHERE id = :id;
    ";
    $stmt = $dbconnect->prepare($query);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $message = 
      '<div class="alert alert-success" role="alert">
        Product deleted successfully.
      </div>';
  } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
  }
  }
//update
    if (isset($_POST['updateBtn'])) {    
    $name    = trim($_POST['name']);
    $price   = trim($_POST['price']);
$description = trim($_POST['description']);
$quantity    = trim($_POST['quantity']);
      $id    = trim($_POST['id']);
//$file_name   = $_FILES['file']['name'];
//$file_loc    = $_FILES['file']['tmp_name'];
//$file_store  = "image/".$file_name;
//if(!move_uploaded_file($file_loc, $file_store)){
//}else{
        
    try {
      $query = "
        UPDATE products
        SET description = :description,name = :name,price = :price,quantity = :quantity
        WHERE id = :id;
      ";
      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':description', $description);
      $stmt->bindValue(':price', $price);
//      $stmt->bindValue(':img', $file_name);
      $stmt->bindValue(':quantity', $quantity);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
//     $message =  "<ul style='background-color:#d4edda;'>Post updated successfully</ul>";
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
    }
    


//fetch all information
    try {
  $query = "SELECT * FROM products;";
  $stmt = $dbconnect->query($query);
  $products = $stmt->fetchAll();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
?>

<?php include('layout/header.php'); ?>
<body>

    <div class="container">
        <h2>Sweden Bangla trade venture background image</h2>
        <p>Sweden Bangla trade venture menu</p>

        <form action="" method="post" enctype="multipart/form-data">
            <!--   <label>Name:</label>-->
            <input type="text" name="name" placeholder="Product name">
            <!--   <label>Price:</label>-->
            <input type="text" name="price" placeholder="Price/unit">
            <label>Choose Image:</label>
            <input type="file" name="file"><br>
            <textarea name="description" class="form-control mb-1" placeholder="Product Description" rows="5" cols="30"></textarea>
            <input type="text" name="quantity" placeholder="quantity"><br><br>

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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $key => $product) { ?>
                <tr>
                    <td><?php echo $product['quantity']; ?> </td>
                    <td><img src="image/<?php echo $product['img']; ?>" width="50px" height="50px"></td>
                    <td><?php echo $product['name']; ?> </td>
                    <td><?php echo $product['price']; ?> </td>
                    <td><?php echo $product['description']; ?></td>
                    <td>
                    <!--delete-->
                         <form action="" method="POST" class="float-right">
                            <input type="hidden" name="hidId" value="<?=$product['id']?>">
                            <input type="submit" name="deleteBtn" value="Delete" class="btn btn-danger delete-product-btn">
                        </form>
                        <!--Update post-->
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal" 
                        data-name="<?=htmlentities($product['name'])?>" 
                        data-price="<?=htmlentities($product['price'])?>" 
                        data-quantity="<?=htmlentities($product['quantity'])?>" 
                        data-description="<?=htmlentities($product['description'])?>" 
                        data-id="<?=htmlentities($product['id'])?>">Update</button>
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
                            <label for="recipient-name" class="col-form-label">Update Title: </label>
                            <input type="text" class="form-control" name="name" for="recipient-name">
                            <label for="recipient-name" class="col-form-label">Update Description: </label>
                            <textarea class="form-control" name="description" for="recipient-name" rows="6"></textarea>
                            <label for="recipient-name" class="col-form-label">Update Price: </label>
                            <input type="text" class="form-control" name="price" for="recipient-name">
                            <label for="recipient-name" class="col-form-label">Update quantity: </label>
                            <input type="text" class="form-control" name="quantity" for="recipient-name">
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
        var button      = $(event.relatedTarget); // Button that triggered the modal
        var name        = button.data('name'); // Extract info from data-* attributes
        var price       = button.data('price'); // Extract info from data-* attributes
        var description = button.data('description'); // Extract info from data-* attributes
//        var file        = button.data('file'); // Extract info from data-* attributes
        var quantity    = button.data('quantity'); // Extract info from data-* attributes
        var id          = button.data('id'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find(".modal-body input[name='name']").val(name);
        modal.find(".modal-body textarea[name='description']").val(description);
        modal.find(".modal-body input[name='price']").val(price);
        modal.find(".modal-body input[name='quantity']").val(quantity);
//        modal.find(".modal-body input[name='file']").val(file);
        modal.find(".modal-body input[name='id']").val(id);
    });
    </script>

 <?php include('layout/footer.php'); ?>
