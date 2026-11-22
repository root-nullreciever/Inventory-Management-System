<?php
include 'db_connect.php';

$sups = $conn->query("SELECT * FROM supplier_record");
if (!$sups) {
    echo "MAY ERROR SA QUERY: " . $conn->error;
} else {
    echo "Bilang ng supplier: " . $sups->num_rows . "<br><br>";
    while ($s = $sups->fetch_assoc()) {
        echo "ID: " . $s['Supplier_id'] . " - NAME: " . $s['Supplier_name'] . "<br>";
        // Para makita natin lahat ng column names:
        print_r($s);
        echo "<br><br>";
    }
}
?>