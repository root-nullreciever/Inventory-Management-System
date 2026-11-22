<?php
include('db_connect.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['product_id']);
    $supplier_id = intval($_POST['supplier_id']);
    $quantity = intval($_POST['stock_quantity']);
    $date = $_POST['date_received'];

    if ($quantity > 0) {
        // Simulan ang transaction para sabay sila
        $conn->begin_transaction();
        try {
            // 1. Mag-INSERT sa stock_in table
            $sql1 = "INSERT INTO stock_in (Product_Id, Supplier_Id, stock_quantity, Date_Received) VALUES ($product_id, $supplier_id, $quantity, '$date')";
            $conn->query($sql1);

            // 2. Mag-UPDATE ng stock sa product_record - DITO YUNG DAGDAG!
            $sql2 = "UPDATE product_record SET stock_quantity = stock_quantity + $quantity WHERE Product_Id = $product_id";
            $conn->query($sql2);

            $conn->commit();
            $message = "<div style='color:green; font-weight:bold;'>Matagumpay! Nadagdagan na ang stock!</div>";
        } catch (Exception $e) {
            $conn->rollback();
            $message = "<div style='color:red; font-weight:bold;'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        $message = "<div style='color:red;'>Dapat mas mataas sa 0 ang quantity.</div>";
    }
}

$products_list = $conn->query("SELECT Product_Id, Product_Name, stock_quantity FROM product_record");
$suppliers_list = $conn->query("SELECT Supplier_Id FROM supplier_record");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock-In</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f4f4f9; }
        .container { max-width: 450px; background: white; padding: 30px; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        select, input, button { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; font-size: 16px; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
<div class="container">
    <h2>Stock-In (Pumasok na Stock)</h2>
    <?php echo $message; ?>
    <form method="POST">
        <div class="form-group">
            <label>Piliin ang Produkto:</label>
            <select name="product_id" required>
                <option value="">-- Pumili ng Produkto --</option>
                <?php while($row = $products_list->fetch_assoc()): ?>
                <option value="<?php echo $row['Product_Id']; ?>"><?php echo $row['Product_Name']; ?> (Stock ngayon: <?php echo $row['stock_quantity']; ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Piliin ang Supplier:</label>
            <select name="supplier_id" required>
                <option value="">-- Pumili ng Supplier --</option>
                <?php while($row = $suppliers_list->fetch_assoc()): ?>
                <option value="<?php echo $row['Supplier_Id']; ?>">Supplier ID: <?php echo $row['Supplier_Id']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Dami ng Idadagdag:</label>
            <input type="number" name="stock_quantity" min="1" required>
        </div>
        <div class="form-group">
            <label>Date Received:</label>
            <input type="date" name="date_received" required>
        </div>
        <button type="submit">I-save ang Stock-In</button>
    </form>
</div>
</body>


<div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
<a href="dashboard.php" style="background: #333; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">← Back to Dashboard</a>
<a href="logout.php" style="background: red; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Log Out</a>
</div>










</html>