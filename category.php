<?php include('db_connect.php'); ?>

<?php
// PAG NAG-ADD NG CATEGORY, METS!
if(isset($_POST['add'])){
    $category_name = $_POST['category_name'];

    $conn->begin_transaction();

    $params = "?";
    $types = "s";
    $args = [$category_name];

    $query = "INSERT INTO category_record (Category_Name) VALUES ($params)";
    $stmt = $conn->prepare($query);

    if($stmt){
        $stmt->bind_param($types, ...$args);
        if($stmt->execute()){
            echo "<script>alert('Added Successfully!'); </script>"; 
        }
        else {
            $conn->rollback(); 
            echo "<script>alert('$stmt->error!'); </script>"; 
        }
    }
    else { echo "<script>alert('$conn->error!'); </script>"; }
    
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Category</title>
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
<h2>Category Record</h2>

<h3>Add Category</h3>
<form method="POST">
<input type="text" name="category_name" placeholder="Category Name - ex. Snacks, Drinks, School Supplies" required><br>
<button type="submit" name="add">Add Category</button>
</form>

<table>
<tr>
<th>Category ID</th>
<th>Category Name</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM category_record ORDER BY Category_Id ASC");
while($row = $result->fetch_assoc()){
?>
<tr>
<td><?php echo $row['Category_Id']; ?></td>
<td><?php echo $row['Category_Name']; ?></td>
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