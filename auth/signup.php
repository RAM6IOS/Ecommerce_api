<?php
include "../Connect.php";
include "../functions.php";

try {
    // التحقق من وجود البيانات المرسلة
    if(isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['user_password']) && isset($_POST['user_phone'])  ) {
        $username = $_POST['user_name'];
        $email = $_POST['user_email'];
        $password = sha1( $_POST['user_password']);
        $phone = $_POST["user_phone"];
        $verfiycode = rand(100000, 999999);
        $result = addItem('user', ['user_email' => $email , 'user_phone' => $phone]);
        $count = $result["count"];
        if ($count > 0) {
            echo json_encode(['status' => 'failure']);
        } else {
           instardata('user',['user_name','user_email', 'user_password','user_phone','user_verfiycode'],[ $username, $email,  $password, $phone, $verfiycode]);
            // جلب ID السجل الأخير المُدخل
            $userId = $con->lastInsertId();
            // إعداد وتنفيذ الاستعلا>
            $stmt = $con->prepare("SELECT * FROM `user` WHERE `user_email` = ? ");
            // Array
    $stmt->execute(array($email));
    //استرجاع بيانات المستخدم المُدخل
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
           // sndEmail( $email , $verfiycode);
            echo json_encode(['status' => 'success', 'data' =>  $user ]);
        }
    } else {
        echo json_encode(['status' => 'failure', 'message' => 'Missing POST data']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
