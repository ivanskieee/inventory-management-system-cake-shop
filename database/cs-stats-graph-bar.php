<?php

include('connection.php');

$stmt = $conn->prepare("SELECT id, supplier_name FROM suppliers");
$stmt->execute();
$rows = $stmt->fetchAll();

$categories = [];
$barchartdata = [];

foreach($rows as $row){
    $id = $row['id'];

    $categories[] = $row['supplier_name'];

    $stmt = $conn->prepare("SELECT COUNT(*) as p_count FROM productssuppliers WHERE productssuppliers.supplier='". $id . "'");
    $stmt->execute();
    $row = $stmt->fetch();

    $count = $row['p_count'];
    $barchartdata[] = (int) $count;

}




    

  

