<?php
include "../Connect.php";
include "../functions.php";


if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $name = $_POST['name'];
    $stmt = $con->prepare("SELECT * FROM `categories` ");
    $stmt->execute(array());
    $count = $stmt->rowCount();

    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($count > 0) {
        echo json_encode(['status' => 'success' ,'data' =>  $user]);
        

    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }
    
    
    
}

?>