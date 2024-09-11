<?php

include('connection.php');

$results = [];


    $stmt = $conn->prepare("SELECT SUM(price) AS total_price from products");
    $stmt->execute();
    $row = $stmt->fetch();

    $sum = $row['total_price'];
    $results[] = [
        'name' => strtoupper('Ingredients Capital'),
        'y' => (int) $sum
        
    ];
    

    $stmt = $conn->prepare("SELECT SUM(price) AS total_price from productscake");
    $stmt->execute();
    $row = $stmt->fetch();

    $sum = $row['total_price'];
    
    $results[] = [
        'name' => strtoupper('Products Sales'),
        'y' => (int) $sum
        
    ];
   
    

  

