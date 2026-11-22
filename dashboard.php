<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location: login.php"); exit(); }
include 'db_connect.php';
$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Inventory Management Dashboard</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Arial, sans-serif; }
body { background:#F2F2F2 !important; display:flex; }
.sidebar { width:240px !important; background:#fff !important; height:100vh; padding:20px 15px; position:fixed; left:0; top:0; border-right:1px solid #eee; }
.sidebar h2 { text-align:center; font-size:20px; margin-bottom:5px; color:#333 !important; }
.sidebar p { text-align:center; color:#777; font-size:14px; margin-bottom:20px; }
.sidebar a { display:block !important; padding:12px 15px !important; color:#333 !important; text-decoration:none !important; border-radius:8px; margin:5px 0; background:transparent !important; }
.sidebar a.active, .sidebar a:hover { background:#FCE0E6 !important; color:#B83A5A !important; font-weight:600; }
.main { margin-left:240px !important; flex:1; padding:20px 30px; }
.main h1 { margin-bottom:20px; color:#222; }
.cards { display:grid; grid-template-columns:repeat(4, 1fr); gap:15px; }
.card { background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
.card h3 { font-size:14px; color:#777; font-weight:400; }
.card p { font-size:32px; font-weight:bold; margin:5px 0; color:#222; }
</style>
</head>
<body>
<div class="sidebar">
<h2>Inventory System</h2>
<p>Hi, <?php echo $_SESSION['username']; ?> (Admin)</p>
<a href="dashboard.php" class="active">Dashboard</a>
<a href="product.php">Product</a>
<a href="supplier.php">Supplier</a>
<a href="stockin.php">Stock In</a>
<a href="stockout.php">Stock Out</a>
<a href="inventory_report.php">Inventory Report</a>
<a href="supplier.php">Supplier Record</a>
<a href="category.php">Category Record</a>
<a href="logout.php">Logout</a>
</div>
<div class="main">
<h1>Welcome sa Dashboard!</h1>
<div class="cards">
<div class="card"><h3>Total Products</h3><p><?php echo $total; ?></p></div>
<div class="card"><h3>Low Stock</h3><p>0</p></div>
<div class="card"><h3>Total Sales</h3><p>0</p></div>
<div class="card"><h3>Out of Stock</h3><p>0</p></div>
</div>
</div>
</body>
</html>