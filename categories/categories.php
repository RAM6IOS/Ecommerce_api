<?php
include "../Connect.php";
include "../functions.php";


if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $categories = $_POST['categories_name'];
    $stmt = $con->prepare("SELECT * FROM `categories` WHERE `categories_name` = ? ");
    $stmt->execute(array($categories));
    $count = $stmt->rowCount();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($count > 0) {
        echo json_encode(['status' => 'success' ,'data' =>  $user]);
        

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