<?php
include "../Connect.php";
include "../functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST") { 

    $email = $_POST['user_email'];
    $verfiycode = rand(100000, 999999);
    $result = addItem('user', ['user_email' => $email]);
    $count = $result["count"];

    /*
    function UPDATEdata( $cloumname , array $rowname = null , array $params = null ){
        global $con ;

        $stmt = $con->prepare("UPDATE $cloumname SET  $rowname WHERE $params ");
        $stmt->execute(array( $rowname, $params  ));
        $count1 = $stmt->rowCount();

        return $con  ;
    };
    */
    if($count > 0) {
        //sndEmail( $email , $verfiycode);
       // UPDATEdata('user', ['user_verfiycode' => $verfiycode], ['user_email' => $email] );
        
        $stmt = $con->prepare("UPDATE `user` SET  `user_verfiycode` = ?  WHERE `user_email` = ? ");
        $stmt->execute(array( $verfiycode , $email ));
        $count1 = $stmt->rowCount();
        

        echo json_encode(['status' => 'success']);
        
    } else {
        echo json_encode(['status' => 'Invalid']);
        
    }
}

    ?>