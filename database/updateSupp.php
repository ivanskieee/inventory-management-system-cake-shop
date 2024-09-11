<?php
$supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name']: '';
$supplier_location = isset($_POST['supplier_location']) ? $_POST['supplier_location']: '';
$email = isset($_POST['email']) ? $_POST['email']: '';


$supplier_id = $_POST['sid'];




try{
$sql = "UPDATE suppliers 
            SET 
            supplier_name=?, supplier_location=?, email=?
                WHERE id=?";

include('connection.php');

$stmt = $conn->prepare($sql);
$stmt->execute([$supplier_name, $supplier_location, $email, $supplier_id]);

$sql = "DELETE FROM productssuppliers WHERE supplier=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$supplier_id]);

$products = isset($_POST['products']) ? $_POST['products']: [];
    foreach($products as $product){
        $supplier_data = [
            'supplier_id' => $supplier_id,
            'product_id' => $product
            
            
        ];

        $sql = "INSERT INTO 
        productssuppliers(supplier, product) 
        VALUES (:supplier_id, :product_id)";
    
    
    
        $stmt = $conn->prepare($sql);
        $stmt->execute($supplier_data);
    }

$response = [
    'success' => true,
    'message' => "<strong>$supplier_name </strong> successfully updated to the system."
];

} catch (Exception $e){
    $response = [
        'success' => false,
        'message' => "Error processing your request"
    ];
}



echo json_encode($response);
