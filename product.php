<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <a href="dashboard.php">Back to Dashboard</a> | 
    <a href="add_product.php">+ Add Product</a>
    <h2>Product List</h2>

    <table class="data-table">
        <thead>
            <tr><th>ID</th><th>Image</th><th>Product Name</th><th>Unit Price</th><th>Stock</th><th>Category</th><th>Supplier</th></tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT p.*, c.Category_Name, s.Supplier_name FROM product_record p LEFT JOIN category_record c ON p.Category_Id = c.Category_Id LEFT JOIN supplier_record s ON p.Supplier_id = s.Supplier_id");
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row['Product_Id']."</td><td><img src='uploads/".$row['Product_Image']."' width='60' height='60'></td><td>".$row['Product_Name']."</td><td>".$row['Unit_Price']."</td><td>".$row['stock_quantity']."</td><td>".$row['Category_Name']."</td><td>".$row['Supplier_name']."</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
    $(document).ready(function () {
        $(".data-table").DataTable();
    });
    </script>
</body>


<div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
<a href="dashboard.php" style="background: #333; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">← Back to Dashboard</a>
<a href="logout.php" style="background: red; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Log Out</a>
</div>









</html>