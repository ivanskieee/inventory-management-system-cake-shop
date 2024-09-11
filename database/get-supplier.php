<?php
include('connection.php');

$id = $_GET['id'];



$stmt = $conn->prepare("SELECT * FROM suppliers WHERE id=$id");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $conn->prepare("SELECT product_name, products.id FROM products, productssuppliers WHERE productssuppliers.supplier=$id AND productssuppliers.product = products.id");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$row['products'] = array_column($products,'id');


echo json_encode($row);



