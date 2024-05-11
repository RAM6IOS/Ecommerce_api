<?php
include "../Connect.php";
include "../functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $password = sha1($_POST['user_password']) ;
    $email = $_POST['user_email'];
     $updat = updateData2('user', ["user_password" => $password ] , ["user_email" => $email]);
     $count = $updat["count"];
    if($count > 0) {
        //sndEmail( $email , $verfiycode);
            echo json_encode(['status' => 'success']);  
    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }
}

    ?>