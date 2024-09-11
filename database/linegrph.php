<?php

include('connection.php');


$stmt = $conn->prepare("SELECT price, created_at FROM productscake ORDER BY created_at ASC");
$stmt->execute();
$rows = $stmt->fetchAll();

$line_gres = [];
foreach($rows as $row){
    $key = date('Y-m-d', strtotime($row['created_at']));
    $line_gres[$key] = isset($line_gres[$key]) ? $line_gres[$key] + (int) $row['price'] : (int) $row['price'];
}

$line_Graph = array_keys($line_gres);
$line_gres = array_values($line_gres);



    

  

