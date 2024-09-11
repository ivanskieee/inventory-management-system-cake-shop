<?php
include('connection.php');

$id = $_GET['id'];





$stmt = $conn->prepare("SELECT supplier_name, suppliers.id FROM suppliers, productssuppliers WHERE productssuppliers.product=$id AND productssuppliers.supplier = suppliers.id");
$stmt->execute();
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);



echo json_encode($suppliers);



