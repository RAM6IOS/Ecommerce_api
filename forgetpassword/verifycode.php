<?php
include "../Connect.php";
include "../functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $verfiycode = $_POST['user_verfiycode'];
    
    $stmt = $con->prepare("SELECT * FROM `user` WHERE `user_verfiycode` = ?  ");

    $stmt->execute(array($verfiycode));
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