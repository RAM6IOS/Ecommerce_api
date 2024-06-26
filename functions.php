<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}


function instardata(string $tableName ,array $columns ,array $values ){
    try {
    global $con;
    $columnNames = implode(', ', $columns);
    $placeholders = implode(', ', array_fill(0, count($values), '?'));
    // تجهيز عبارة WHERE لتحديد الصفوف التي يجب تحديثها
    $stmt = $con->prepare("INSERT INTO $tableName ($columnNames) VALUES ($placeholders)");
    $stmt->execute(array_values($values));
    $count = $stmt->rowCount();
    // إرجاع عدد الصفوف المتأثرة
    return array( "count" => $count);
    } catch (PDOException $e) {
        // يمكنك إدراج رمز خطأ مخصص هنا أو إعادة رمي الاستثناء
        return -1;
    }

};
function updateData2( string $tableName, array $updateFields, array $conditionFields) {
    try {
        global $con;
        // تجهيز عبارة SET لتحديث الصفوف
        $setClause = implode(', ', array_map(fn($key) => "$key = ?", array_keys($updateFields)));
    
        // تجهيز عبارة WHERE لتحديد الصفوف التي يجب تحديثها
        $whereClause = implode(' AND ', array_map(fn($key) => "$key = ?", array_keys($conditionFields)));
    
        // إعداد الاستعلام مع الباراميترات
        $stmt = $con->prepare("UPDATE $tableName SET $setClause WHERE $whereClause");
    
        // تنفيذ الاستعلام مع تمرير قيم الباراميترات
        $stmt->execute(array_merge(array_values($updateFields), array_values($conditionFields)));
    
        // الحصول على عدد الصفوف التي تم تحديثها
        $count = $stmt->rowCount();
    
        // إرجاع عدد الصفوف المتأثرة
        return array( "count" => $count);
    } catch (PDOException $e) {
        // يمكنك إدراج رمز خطأ مخصص هنا أو إعادة رمي الاستثناء
        return -1;
    }
};

    function addItem(string $filename, array $params = null) {
        global $con;
        // Constructing the WHERE clause with placeholders
        $data = array();
        if($params != null){
            $whereClause = implode(' AND ', array_map(fn($param) => "$param = ?", array_keys($params)));
            $stmt = $con->prepare("SELECT * FROM $filename WHERE $whereClause");
            // Execute the prepared statement with parameters
            $stmt->execute(array_values($params));
        } else {
            $stmt = $con->prepare("SELECT * FROM $filename");
            // Execute the prepared statement with parameters
            $stmt->execute();
        }
        $count  = $stmt->rowCount();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array("data" => $data, "count" => $count);
    }

    function addItem2(string $filename, array $params = null) {
        global $con;
        // Constructing the WHERE clause with placeholders
        $data = array();
        if($params != null){
            $whereClause = implode(' AND ', array_map(fn($param) => "$param = ?", array_keys($params)));
            $stmt = $con->prepare("SELECT * FROM $filename WHERE $whereClause");
            // Execute the prepared statement with parameters
            $stmt->execute(array_values($params));
        } else {
            $stmt = $con->prepare("SELECT * FROM $filename");
            // Execute the prepared statement with parameters
            $stmt->execute();
        }
        $count  = $stmt->rowCount();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return  $count ;
    }


    

function getAllData($table, $where = null, $values = null)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    return $count;
}

function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;

}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($imageRequest)
{
  global $msgError;
  $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
  $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
  $imagesize  = $_FILES[$imageRequest]['size'];
  $allowExt   = array("jpg", "png", "gif", "mp3", "pdf");
  $strToArray = explode(".", $imagename);
  $ext        = end($strToArray);
  $ext        = strtolower($ext);

  if (!empty($imagename) && !in_array($ext, $allowExt)) {
    $msgError = "EXT";
  }
  if ($imagesize > 2 * MB) {
    $msgError = "size";
  }
  if (empty($msgError)) {
    move_uploaded_file($imagetmp,  "../upload/" . $imagename);
    return $imagename;
  } else {
    return "fail";
  }
}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

   
}

function sndEmail($addAddress ,$verificationCode){

   
    
    require 'vendor/autoload.php';
    $mail = new PHPMailer(true);

    
    try {
        // إعداد المعلمات اللازمة للبريد الإلكتروني
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ios191169@gmail.com';
        $mail->Password = 'GOOGLEIOS13';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
    
        // إعداد محتوى البريد الإلكتروني
        $mail->setFrom('ios191169@gmail.com', 'Ramzi');
        $mail->addAddress($addAddress, 'Recipient Name');
        $mail->Subject = 'Verification Code';
         // Replace with your verification code
        $mail->Body = 'Your verification code is: ' . $verificationCode;
    
        // إرسال البريد الإلكتروني
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


}