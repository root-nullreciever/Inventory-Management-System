<?php
include 'db_connect.php';

if(isset($_POST['save'])){
  $name = $_POST['product_name'];
  $price = $_POST['unit_price'];
  $stock = $_POST['stock_quantity'];
  $cat = $_POST['category_id'];
  $sup = $_POST['supplier_id'];

  // Ito yung maglilipat ng picture sa uploads folder
  $image = $_FILES['product_image']['name'];
  $tmp = $_FILES['product_image']['tmp_name'];
  move_uploaded_file($tmp, "uploads/".$image);

  $conn->query("INSERT INTO product_record (Product_Name, Unit_Price, Stock_Quantity, Category_Id, Supplier_Id, Product_Image) VALUES ('$name','$price','$stock','$cat','$sup','$image')");

  echo "<script>alert('Na-save na with picture!'); window.location='product.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Product</title></head>
<body>
    <a href="dashboard.php">Back to Dashboard</a>
    <h2>Add Product</h2>
    <form method="POST" enctype="multipart/form-data">
        Product Name: <input type="text" name="product_name" required><br><br>
        Unit Price: <input type="number" step="0.01" name="unit_price" required><br><br>
        Stock Quantity: <input type="number" name="stock_quantity" required><br><br>
        <br><br>
        Product Image: <input type="file" name="product_image" required>
        <br><br>
        Category: 
        <select name="category_id" required>
            <option value="">-- Piliin --</option>
            <?php
            $cats = $conn->query("SELECT * FROM category_record");
            while ($c = $cats->fetch_assoc()) {
                echo "<option value='".$c['Category_Id']."'>".$c['Category_Name']."</option>";
            }
            ?>
        </select><br><br>

        Supplier:
        <select name="supplier_id" required>
            <option value="">-- Piliin --</option>
            <?php
            $sups = $conn->query("SELECT * FROM supplier_record");
            while ($s = $sups->fetch_assoc()) {
                echo "<option value='".$s['Supplier_id']."'>".$s['Supplier_name']."</option>";
            }
            ?>
        </select><br><br>

        <button type="submit" name="save">SAVE</button>
    </form>
</body>
</html>