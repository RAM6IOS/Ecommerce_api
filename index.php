<?php 

include './connect.php';
include "./functions.php";
$table = "user";
// $name = filterRequest("namerequest");
$data = array( 
"name" => "wael",
"email" => "wael@gmail.com",
//"phone" => "324234",
"password" => "fdf",
//"verfiycode" => "3243243",       
);
$count = insertData($table , $data);