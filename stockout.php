<?php
include('db_connect.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['product_id'] ?? 0);
    $quantity = intval($_POST['stock_quantity'] ?? 0);
    $date = $_POST['date_out'];

    if ($quantity <= 0) {
        $message = "<div style='color:red; font-weight:bold;'>Dapat mas mataas sa 0 ang quantity.</div>";
    } else {
        // 1. Kunin muna yung stock ngayon para ma-check
        $check = "SELECT stock_quantity, Product_Name FROM product_record WHERE Product_Id = ?;";
        $stmt = $conn->prepare($check);

        if($stmt){
            $stmt->bind_param('i', $product_id);

            if($stmt->execute()){
                $get_res = $stmt->get_result();

                while($row = $get_res->fetch_assoc()){
                    $current_stock = $row['stock_quantity'];
                }
                if ($quantity > $current_stock) {
                    $message = "<div style='color:red; font-weight:bold;'>Hindi pwede! Stock mo lang ay $current_stock, pero gusto mo mag-Stock Out ng $quantity. Kulang!</div>";
                } else {
                    // 2. Kung kasya, gawin yung dalawa ng sabay
                    $conn->begin_transaction();
                    try {
                        // Mag-INSERT sa stock_out table
                        $insertparams = "?,?,?";
                        $insertTypes = "iis";
                        $insertArgs = [$product_id, $quantity, $date];
                        
                        $sql1 = "INSERT INTO stock_out (Product_Id, stock_quantity, Date_Out) VALUES ($insertparams)";
                        $sql1stmt = $conn->prepare($sql1);
                        $sql1stmt->bind_param($insertTypes, ...$insertArgs);
                        $sql1stmt->execute();

                        // Mag-BAWAS ng stock sa product_record - DITO YUNG BAWAS!
                        $updateTypes = "ii";
                        $updateArgs = [$quantity, $product_id]; 
                        $sql2 = "UPDATE product_record SET stock_quantity = stock_quantity - ? WHERE Product_Id = ?";
                        $update = $conn->prepare($sql2);
                        $update->bind_param($updateTypes, ...$updateArgs);
                        $update->execute();

                        $conn->commit();
                        $message = "<div style='color:green; font-weight:bold;'>Matagumpay! Nabawasan na ang stock!</div>";
                    } catch (Exception $e) {
                        $conn->rollback();
                        $message = "<div style='color:red; font-weight:bold;'>Error: " . $e->getMessage() . "</div>";
                    }
                }
            } else { echo "<script>alert('$stmt->error!'); </script>"; }   
        } else { echo "<script>alert('$conn->error!'); </script>"; }        

    }
}

$products_list = $conn->query("SELECT Product_Id, Product_Name, stock_quantity FROM product_record");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock-Out</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f4f4f9; }
        .container { max-width: 450px; background: white; padding: 30px; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        select, input, button { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #dc3545; color: white; border: none; font-size: 16px; cursor: pointer; }
        button:hover { background: #c82333; }
    </style>
</head>
<body>
<div class="container">
    <h2>Stock-Out (Lumabas na Stock)</h2>
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
            <label>Dami ng Ibabawas:</label>
            <input type="number" name="stock_quantity" min="1" required>
        </div>
        <div class="form-group">
            <label>Date Out:</label>
            <input type="date" name="date_out" required>
        </div>
        <button type="submit">I-save ang Stock-Out</button>
    </form>
</div>
</body>

<div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
<a href="dashboard.php" style="background: #333; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">← Back to Dashboard</a>
<a href="logout.php" style="background: red; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Log Out</a>
</div>




</html>