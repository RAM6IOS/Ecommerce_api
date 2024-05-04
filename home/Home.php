<?php
include "../Connect.php";
include "../functions.php";


$alldata = array();

    $stmt = $con->prepare("SELECT * FROM `categories` ");
    $count = $stmt->rowCount();
    $stmt->execute(array());
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $con->prepare("SELECT * FROM `items` ");
    $count = $stmt->rowCount();
    $stmt->execute(array());
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $alldata['categories'] = $user;
    $alldata["items"] = $items ;
        echo json_encode(['status' => 'success' ,'data' =>  $alldata]);
        

/*
$stmt = $con->prepare("SELECT * FROM `categories` ");
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