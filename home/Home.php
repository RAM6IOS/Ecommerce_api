<?php
include "../Connect.php";
include "../functions.php";

    $items = addItem('items', ['items_active' => 1]);
    $categories = addItem('categories');
    $alldata['categories'] = $categories ;
    $alldata["items"] = $items ;


    $stmt = $con->prepare("SELECT * FROM `items` ");
    $stmt->execute(array());
    $count = $stmt->rowCount();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($count > 0) {
        echo json_encode(['status' => 'success' ,'data' =>  $user]);
    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }

echo json_encode(['status' => 'success' ,'data' =>  $alldata]);
        


    
?>