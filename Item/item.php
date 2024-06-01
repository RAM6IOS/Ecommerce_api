<?php
include "../Connect.php";
include "../functions.php";

    $items = addItem('items', ['items_active' => 1]);
echo json_encode(['status' => 'success' ,'data' => $items]);
        


    
?>