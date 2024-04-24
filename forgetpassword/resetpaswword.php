<?php
include "../Connect.php";
include "../functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $password = sha1($_POST['user_password']) ;
    $email = $_POST['user_email'];
    
    
    $stmt = $con->prepare("UPDATE `user` SET  `user_password` = ?  WHERE `user_email` = ?");
    $stmt->execute(array( $password , $email ));
    $count = $stmt->rowCount();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if($count > 0) {
        
        //sndEmail( $email , $verfiycode);

            echo json_encode(['status' => 'success']);  

    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }
}

    ?>