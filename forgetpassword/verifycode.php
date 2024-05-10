<?php
include "../Connect.php";
include "../functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $verfiycode = $_POST['user_verfiycode'];
$result = addItem('user', ['user_verfiycode' => $verfiycode]);
$count = $result["count"];
if ($count > 0) {
    echo json_encode(['status' => 'success' ]);  
} else {
    echo json_encode(['status' => 'Invalid']);
}
}

    ?>