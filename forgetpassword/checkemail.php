<?php
include "../Connect.php";
include "../functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST['user_email'];
    $verfiycode = rand(100000, 999999);
    
    $stmt = $con->prepare("SELECT * FROM `user` WHERE `user_email` = ?  ");

    $stmt->execute(array($email));
    $count = $stmt->rowCount();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($count > 0) {
        //sndEmail( $email , $verfiycode);
        $stmt = $con->prepare("UPDATE `user` SET  `user_verfiycode` = ?  WHERE `user_email` = ? ");
        $stmt->execute(array( $verfiycode , $email ));
        $count1 = $stmt->rowCount();

        echo json_encode(['status' => 'success']);
        
    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }
}

    ?>