<?php
include "../Connect.php";
include "../functions.php";


/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];

    // Retrieve user data from the database based on the provided username
    $stmt = $con->prepare("SELECT * FROM `user` WHERE `user_email` = ? ");
    $stmt->execute(array($email));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and verify the password
    if ($user && password_verify($password, $user['user_password'])) {
        // User is authenticated
        echo json_encode(['status' => 'success' ]);
        echo "Login successful!";
    } else {
        // Invalid credentials
        echo json_encode(['status' => 'success' ]);
        echo "Invalid username or password";
    }
}


*/


if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST['user_email'];
    $password = sha1($_POST['user_password']) ;
    $stmt = $con->prepare("SELECT * FROM `user` WHERE `user_email` = ?  AND  `user_password` = ? ");

    $stmt->execute(array($email  , $password));
    $count = $stmt->rowCount();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if($count > 0) {
        echo json_encode(['status' => 'success']);
        

    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }
    
    /*
    if ($user) {
        // تحقق من صحة كلمة المرور
        if (password_verify($password, $user['user_password'])) {
            // كلمة المرور صحيحة
            echo json_encode(['status' => 'success']);
            return;
        } else {
            // كلمة المرور غير صحيحة
            echo json_encode(['status' => 'Invalid']);
            return;
        }
    } else {
        // المستخدم غير موجود
        echo json_encode(['status' => 'User not found']);
        return;
    }
    */
    
}

?>