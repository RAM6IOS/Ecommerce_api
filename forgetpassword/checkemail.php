<?php
include "../Connect.php";
include "../functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST") { 

    $email = $_POST['user_email'];
    $verfiycode = rand(100000, 999999);
    $result = addItem('user', ['user_email' => $email]);
    $count = $result["count"];
    if($count > 0) {
        updateData2('user', ['user_verfiycode' => $verfiycode], ['user_email' => $email] );
        echo json_encode(['status' => 'success' ]);
    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }
}

    ?>