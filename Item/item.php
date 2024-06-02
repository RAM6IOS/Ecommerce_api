<?php
include "../Connect.php";
include "../functions.php";

$items_cat = $_POST["items_cat"];
addItem2('items', ['items_cat' => $items_cat]);
//echo json_encode(['status' => 'success' ,'data' => $items]);

/*
$stmt = $con->prepare("SELECT * FROM `items` ");
    $stmt->execute(array());
    $count = $stmt->rowCount();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($count > 0) {
        echo json_encode(['status' => 'success' ,'data' =>  $user]);
    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }
    
    */    


    
?>