<?php
    include('connection.php');


    $stmt = $conn->prepare("SELECT SUM(price) AS total_price from products");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    

    $total_price = $stmt->fetchAll()[0]['total_price'];
    return $total_price;

?>