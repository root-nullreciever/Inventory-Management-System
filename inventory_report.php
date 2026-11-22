<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
<title>Inventory Report</title>
<style>
body { font-family: Arial; margin: 40px; background: #f4f4f9; }
.container { background: white; padding: 20px; border-radius: 8px; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
th { background: #333; color: white; }
</style>
</head>
<body>
<div class="container">
<h2>Inventory Report - Automatic</h2>
<p>Diretso na ito sa product_record kaya laging bago!</p>
<table>
<tr>
<th>Product ID</th>
<th>Product Name</th>
<th>Stock Quantity</th>
<th>Status</th>
</tr>

<?php

$result = $conn->query("SELECT * FROM product_record ORDER BY Product_Id ASC");
while($row = $result->fetch_assoc()){
$stock = $row['stock_quantity'];

$name = $row['product_name'] ?? $row['Product_Name'] ?? $row['ProductName'] ?? $row['name'] ?? '-';

if($stock <= 0){
$status = "Ubus na!";
} elseif($stock <= 10){
$status = "Paubos na!";
} else {
$status = "Marami pa";
}
?>
<tr>
<td><?php echo $row['Product_Id']; ?></td>
<td><?php echo $name; ?></td>
<td><?php echo $stock; ?></td>
<td><?php echo $status; ?></td>
</tr>
<?php } ?>
</table>
</div>
</body>


<div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
<a href="dashboard.php" style="background: #333; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">← Back to Dashboard</a>
<a href="logout.php" style="background: red; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Log Out</a>
</div>













</html>