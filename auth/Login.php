<?php
include "../Connect.php";
include "../functions.php";
if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST['user_email'];
    $password = sha1($_POST['user_password']) ;
    $result = addItem('user', ['user_email' => $email , 'user_password' => $password]);
    $count = $result["count"];

    if($count > 0) {
        echo json_encode(['status' => 'success' ,'data' =>  $user]);
    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }
    
    
}

?>