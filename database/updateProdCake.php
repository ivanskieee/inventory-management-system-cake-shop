<?php

$product_name = $_POST['product_name'];
$price = $_POST['price'];
$description = $_POST['description'];
$pid = $_POST['pid'];


$target_dir = "../uploads/products/";

$file_name_value = NULL;
$file_data = $_FILES['img'];

if($file_data['tmp_name'] !== ''){
$file_name = $file_data['name'];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
$file_name = 'product-' . time() . '.' . $file_ext;


$check = getimagesize($file_data['tmp_name']);


if($check){
    if(move_uploaded_file($file_data['tmp_name'],$target_dir . $file_name)){
        $file_name_value = $file_name;
    }
}

}



try{
$sql = "UPDATE productscake 
            SET 
            product_name=?, price=?, description=?, img=?
                WHERE id=?";

include('connection.php');

$stmt = $conn->prepare($sql);
$stmt->execute([$product_name, $price, $description, $file_name_value, $pid ]);

$sql = "DELETE FROM productssuppliers WHERE product=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$pid]);

$suppliers = isset( $_POST['suppliers']) ? $_POST['suppliers'] : [];
if($suppliers){
    foreach($suppliers as $supplier){
        $supplier_data = [
            'supplier_id' => $supplier,
            'product_id' => $pid
            
            
        ];

        $sql = "INSERT INTO 
        productssuppliers(supplier, product) 
        VALUES (:supplier_id, :product_id)";
    
    
    
        $stmt = $conn->prepare($sql);
        $stmt->execute($supplier_data);
    }
}
$response = [
    'success' => true,
    'message' => "<strong>$product_name </strong> Successfully updated to the system."
];

} catch (Exception $e){
    $response = [
        'success' => false,
        'message' => "Error processing your request"
    ];
}



echo json_encode($response);
