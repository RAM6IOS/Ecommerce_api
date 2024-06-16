<?php
include "../Connect.php";
include "../functions.php";

    $items = addItem('items', ['items_active' => 1]);
    $categories = addItem('categories');
    $alldata['categories'] = $categories ;
    $alldata["items"] = $items ;


echo json_encode(['status' => 'success' ,'data' =>  $alldata]);
        


    
?>