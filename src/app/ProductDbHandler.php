<?php
class ProductDbHandler
{
//fetch
public function bringAll(){
    global $dbconnect;
    try {
  $query = "SELECT * FROM products;";
  $stmt = $dbconnect->query($query);
  $products = $stmt->fetchAll();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
return $products;
}
//update
public function update(){
          global $dbconnect;
          global $id;
          global $name;
          global $description;
          global $price;
          global $quantity;
          global $category;
          global $message;
        try {
      $query = "
        UPDATE products
        SET description = :description,name = :name,price = :price,quantity = :quantity,category = :category
        WHERE id = :id;
      ";
      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':description', $description);
      $stmt->bindValue(':price', $price);
//      $stmt->bindValue(':img', $file_name);
      $stmt->bindValue(':quantity', $quantity);
      $stmt->bindValue(':category', $category);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
     $message =  "<ul style='background-color:#d4edda;'>Product updated successfully</ul>";
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
}
//add
public function add(){
            global $dbconnect;
            global $title;
            global $price;
            global $description;
            global $file_name;
            global $quantity;
            global $category;
            global $message;
    try {
      $query = "
        INSERT INTO products (name, price, description, img, quantity, category)
        VALUES (:name,:price, :description, :image, :quantity, :category);
      ";
      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':name', $title);
      $stmt->bindValue(':price', $price);
      $stmt->bindValue(':description', $description);
      $stmt->bindValue(':image', $file_name);
      $stmt->bindValue(':quantity', $quantity);
      $stmt->bindValue(':category', $category);
      $stmt->execute();   
    $message =  "<ul style='background-color:#d4edda;'>Product uploaded successfully</ul>";
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    } 
}
//delete
public function delete(){
       global $dbconnect;
       global $id;
       global $message;
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
//specific data
public function productById(){
    global $dbconnect;
try {
	$stmt = $dbconnect->prepare("SELECT title,description,price FROM products
    WHERE id = :id");
    $stmt->bindValue(':id',$_GET['hidID']);
    $stmt->execute();
	$post = $stmt->fetch(); 
} catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
 return $post;   
}
}
