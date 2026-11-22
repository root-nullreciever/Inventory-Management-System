<?php include('db_connect.php'); ?>

<?php
// PAG NAG-ADD NG SUPPLIER, METS!
if(isset($_POST['add']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
$supplier_name = $_POST['supplier_name'];
$contact_number = $_POST['contact_number'];
$email = $_POST['email'];
$address = $_POST['address'];

$conn->begin_transaction();

$params = "?, ?, ?, ?";
$types = "ssss";
$args = [$supplier_name, $contact_number, $email, $address];

$query = "INSERT INTO supplier_record (Supplier_name, contact_number, email, address) VALUES ($params);";
$stmt = $conn->prepare($query);

if($stmt){
    $stmt->bind_param($types, ...$args); 
    
    if($stmt->execute()){
        $conn->commit();
    }
    else {
        $conn->rollback();
    }
}
else {echo "<script>alert('$conn->error!'); </script>"; }

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Supplier</title>
<style>
body { font-family: Arial; margin: 40px; background: #f4f4f9; }
.container { background: white; padding: 20px; border-radius: 8px; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
th { background: #333; color: white; }
input { padding: 10px; width: 95%; margin-bottom: 10px; }
button { padding: 10px 20px; background: #333; color: white; border: none; cursor: pointer; }
</style>
</head>
<body>
<div class="container">
<h2>Supplier Record</h2>

<h3>Add Supplier</h3>
<form method="POST">
<input type="text" name="supplier_name" placeholder="Supplier Name" required><br>
<input type="text" name="contact_number" placeholder="Contact Number - ex. 09171234567" required><br>
<input type="email" name="email" placeholder="Email" required><br>
<input type="text" name="address" placeholder="Address" required><br>
<button type="submit" name="add">Add Supplier</button>
</form>

<table>
<tr>
<th>Supplier ID</th>
<th>Supplier Name</th>
<th>Contact Number</th>
<th>Email</th>
<th>Address</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM supplier_record ORDER BY Supplier_id ASC");
while($row = $result->fetch_assoc()){
?>
<tr>
<td><?php echo $row['Supplier_id']; ?></td>
<td><?php echo $row['Supplier_name']; ?></td>
<td><?php echo $row['contact_number']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['address']; ?></td>
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